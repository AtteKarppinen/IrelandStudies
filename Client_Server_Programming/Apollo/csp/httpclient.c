#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include "Practical.h"
#include <unistd.h>

int main(int argc, char *argv[]) {
  char recvbuffer[BUFSIZE]; // I/O buffer
  int numBytes = 0;
  char sendbuffer[BUFSIZE]; // Buffer for sending data

  if (argc < 3)
    DieWithUserMessage("Parameter(s)", "<Server Address> <Server Port>");

    char *servIP = argv[1]; // Server IP Address
    char *getRequest =	"GET /index.html HTTP/1.1\r\n";
//			"Host: www.dit.ie\r\n"
//			"Connection: close\r\n"
//			"\r\n";

    in_port_t servPort = atoi(argv[2]);

    // TCP Stream socket
    int sock = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
    if (sock < 0)
      DieWithSystemMessage("socket() failed");

    // Construct the server address structure
    struct sockaddr_in servAddr; 
    memset(&servAddr, 0, sizeof(servAddr));
    servAddr.sin_family = AF_INET;
    // Convert Address
    int rtnVal = inet_pton(AF_INET, servIP, &servAddr.sin_addr.s_addr);
    if (rtnVal == 0)
      DieWithUserMessage("inet_pton() failed", "invalid address string");
    else if (rtnVal < 0)
      DieWithSystemMessage("inet_pton() failed");

    servAddr.sin_port = htons(servPort); // Server Port

    // Establish the connection to the httpServer
    if (connect(sock,(struct sockaddr *) &servAddr, sizeof(servAddr)) < 0)
      DieWithSystemMessage("connect() failed");

    // Send get request to server
    snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", getRequest);
    ssize_t numBytesSent = send(sock, sendbuffer, strlen(sendbuffer), 0);
    if (numBytesSent < 0)
      DieWithSystemMessage("send() failed");

    while ((numBytes = recv(sock, recvbuffer, BUFSIZE - 1, 0)) > 0) {
      recvbuffer[numBytes] = '\0';
      fputs(recvbuffer, stdout);
    }

    if (numBytes < 0) 
      DieWithSystemMessage("recv() failed");

    fputc('\n', stdout); 

    close(sock);
    exit(0);
}
