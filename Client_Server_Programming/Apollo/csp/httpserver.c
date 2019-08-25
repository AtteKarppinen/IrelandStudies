#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include "Practical.h"
#include <unistd.h>
#include <time.h>

#define HOME_PAGE "HTTP/1.1 200 FileFound\r\nContent-Length: 29\r\nCache-Control: no-cache\r\nConnection: close\r\n\r\n<html><h1>Success</h1></html>"
#define ERROR_PAGE "HTTP/1.1 404 FileNotFound\r\nContent-Length: 29\r\nCache-Control: no-cache\r\nConnection: close\r\n\r\n<html><h1>Failure</h1></html>"

static const int MAXPENDING = 5; // Maximum outstanding connection request

int main(int argc, char *argv[]) {
  char recvbuffer[BUFSIZE]; // Buffer for receiving data from the server
  int numBytes;
  char sendbuffer[BUFSIZE]; // Buffer for sending data to the client
  char discard1[50];
  char discard2[50];
  char uri[200];

  if (argc != 2) // Test for correct number of arguments
    DieWithUserMessage("Parameter(s)", "<Server Port>");

  in_port_t servPort = atoi(argv[1]);

  // Create socket for incoming connections
  int servSock; //Socket descriptor for Server
  if ((servSock = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP)) < 0)
    DieWithSystemMessage("socket() failed");

    // Construct local address structure
    struct sockaddr_in servAddr;                // Local address
    memset (&servAddr, 0, sizeof(servAddr));    // Zero out structure
    servAddr.sin_family = AF_INET;              // IPv4 address family
    servAddr.sin_addr.s_addr = htonl(INADDR_ANY);// Any incoming interface
    servAddr.sin_port = htons(servPort);        // Local Port

    // Bind to the local address
    if (bind(servSock, (struct sockaddr*) &servAddr, sizeof(servAddr)) < 0)
      DieWithSystemMessage("bind() failed");

    // Mark the socket so it will listen for incoming connections
    if (listen(servSock, MAXPENDING) < 0)
      DieWithSystemMessage("listen() failed");

    for (;;) { //Run forever

      // Wait for a client to connect
      int clntSock = accept(servSock, (struct sockaddr *) NULL, NULL);
      if (clntSock < 0)
        DieWithSystemMessage("accept() failed");

      // Receive getRequest
      while ((numBytes = recv(clntSock, recvbuffer, BUFSIZE - 1, 0)) > 0) {
        recvbuffer[numBytes] = '\0';
       // fputs(recvbuffer, stdout); 
        if (strstr(recvbuffer, "\r\n\r\n") > 0)
          break;
      }

      if (numBytes < 0)
        DieWithSystemMessage("recv() failed");

      sscanf(recvbuffer, "%s %s %s", discard1, uri, discard2);
      if (strcmp(uri, "/index.html") == 0)
	      snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", HOME_PAGE);
      else
	      snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", ERROR_PAGE);

      // clntSock is connected to a client!
      ssize_t numBytesSent = send(clntSock, sendbuffer, strlen(sendbuffer), 0);
      if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

      strcpy(uri, "");
      close(clntSock); // Close client Socket

    }
    // NOT REACHED
}
