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
#include <sys/stat.h>

static const int MAXPENDING = 5; // Maximum outstanding connection request

int main(int argc, char *argv[]) {
  char recvbuffer[BUFSIZE]; // Buffer for receiving data from the server
  int numBytes = 0, char_in, count = 0, size = 0; // Variables for file manipulation
  char sendbuffer[BUFSIZE]; // Buffer for sending data to the client
  char discard1[50];
  char discard2[50];
  char path[200] = {'.'};
  struct stat st;
  FILE * hFile;

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

      // Receive data
      while ((numBytes = recv(clntSock, recvbuffer, BUFSIZE - 1, 0)) > 0) {
        recvbuffer[numBytes] = '\0';
        fputs(recvbuffer, stdout);
        if (strstr(recvbuffer, "\r\n\r\n") > 0)
          break;
      }

      if (numBytes < 0)
        DieWithSystemMessage("recv() failed");

      sscanf(recvbuffer, "%s %s %s", discard1, (path+1), discard2);

      if (strcmp(path, "./") == 0) {
        strcpy(path, "index.html");
      }
      hFile = fopen(path, "r");

      if (hFile == NULL) {
        // OPEN ERROR PAGE
        strcpy(path, "error.html");
        hFile = fopen(path, "r");

        stat(path, &st);
        size = st.st_size;

        snprintf(sendbuffer, sizeof(sendbuffer), "HTTP/1.1 404 File not found\r\nContent-Length: %d\r\nCache-Control: no-cache\r\nConnection: close\r\n\r\n", size);
      }
      else {
        // File exists and is open
	stat(path, &st);
	size = st.st_size;

	snprintf(sendbuffer, sizeof(sendbuffer), "HTTP/1.1 200 File found\r\nContent-Length: %d\r\nCache-Control: no-cache\r\nConnection: close\r\n\r\n", size);
      }

      // clntSock is connected to a client!
      ssize_t numBytesSent = send(clntSock, sendbuffer, strlen(sendbuffer), 0); // Send date and time string to the client
      if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

      // Reset outgoing buffer
      strcpy(sendbuffer, "");

      // Read character by character and store content to sendbuffer
      while((char_in = fgetc(hFile)) != EOF) {
	sendbuffer[count] = char_in;
	count++;
      }

      // Send file contents to connected socket
      numBytesSent = send(clntSock, sendbuffer, strlen(sendbuffer), 0);
      if (numBytesSent < 0)
	DieWithSystemMessage("send() failed");

      // Reset all variables and close connection
      strcpy(sendbuffer, "");
      strcpy(recvbuffer, "");
      strcpy(discard1, "");
      strcpy(discard2, "");
      strcpy(path, ".");
      numBytes = 0;
      char_in = 0;
      count = 0;
      size = 0;
      fclose(hFile);
      close(clntSock); // Close client Socket
    }
    // NOT REACHED
}
