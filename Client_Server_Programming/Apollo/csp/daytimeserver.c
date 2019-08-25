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

static const int MAXPENDING = 5; // Maximum outstanding connection request

int main(int argc, char *argv[]) {
  time_t ticks;
  char sendbuffer[BUFSIZE]; // Buffer for sending data to the client

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
      int clntSock = accept(servSock, (struct sockaddr *) NULL, NULL); // Changing NULLs to cliAddr and addrLen clients info can be captured
      if (clntSock < 0)
        DieWithSystemMessage("accept() failed");

      // clntSock is connected to a client!
      snprintf(sendbuffer, sizeof(sendbuffer), "%.24s\r\n", ctime(&ticks)); // Create data and time string in outgoing Buffer
      ssize_t numBytesSent = send(clntSock, sendbuffer, strlen(sendbuffer), 0); // Send date and time string to the client
      if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

      close(clntSock); // Close client Socket
      
    }
    // NOT REACHED
}