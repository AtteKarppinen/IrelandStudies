// Atte Karppinen D18123298

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

//#define HOME_PAGE "HTTP/1.1 200 FileFound\r\nContent-Length: 29\r\nCache-Control: no-cache\r\nConnection: close\r\n\r\n<html><h1>Success</h1></html>"
//#define ERROR_PAGE "HTTP/1.1 404 FileNotFound\r\nContent-Length: 29\r\nCache-Control: no-cache\r\nConnection: close\r\n\r\n<html><h1>Failure</h1></html>"

//#define MOVIE_GRANTED "MOVIE_GRANTED\r\nCURRENT_BALANCE: % d\r\n\r\n"
//#define MOVIE_REJECTED "MOVIE_REJECTED\r\nCURRENT_BALANCE: % d\r\n\r\n"

static const int MAXPENDING = 5; // Maximum outstanding connection requests

int main(int argc, char *argv[])
{
  char recvbuffer[BUFSIZE];               // Buffer for receiving data from the server
  int numBytes, balance = 0, charge_req, top_up; // Setting balance here affects what code will be executed
  char sendbuffer[BUFSIZE];               // Buffer for sending data to the client
  char discard1[50];                      // Movie request: MOVIE_REQUEST
  char discard2[50];                      // Top-up request

  if (argc != 2) // Test for correct number of arguments
    DieWithUserMessage("Parameter(s)", "<Server Port>");

  in_port_t servPort = atoi(argv[1]);

  // Create socket for incoming connections
  int servSock; //Socket descriptor for Server
  if ((servSock = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP)) < 0)
    DieWithSystemMessage("socket() failed");

  // Construct local address structure
  struct sockaddr_in servAddr;                  // Local address
  memset(&servAddr, 0, sizeof(servAddr));       // Zero out structure
  servAddr.sin_family = AF_INET;                // IPv4 address family
  servAddr.sin_addr.s_addr = htonl(INADDR_ANY); // Any incoming interface
  servAddr.sin_port = htons(servPort);          // Local Port

  // Bind to the local address
  if (bind(servSock, (struct sockaddr *)&servAddr, sizeof(servAddr)) < 0)
    DieWithSystemMessage("bind() failed");

  // Mark the socket so it will listen for incoming connections
  if (listen(servSock, MAXPENDING) < 0)
    DieWithSystemMessage("listen() failed");

  for (;;)
  { //Run forever

    // Wait for a client to connect
    int clntSock = accept(servSock, (struct sockaddr *)NULL, NULL);
    if (clntSock < 0)
      DieWithSystemMessage("accept() failed");

    // Receive movie request
    printf("Incoming movie request from the client: ");
    printf("\n");
    while ((numBytes = recv(clntSock, recvbuffer, BUFSIZE - 1, 0)) > 0)
    {
      recvbuffer[numBytes] = '\0';
      fputs(recvbuffer, stdout);
      if (strstr(recvbuffer, "\r\n\r\n") > 0)
        break;
    }

    if (numBytes < 0)
      DieWithSystemMessage("recv() failed");

    sscanf(recvbuffer, "%s %d", discard1, &charge_req); // Receive MOVIE_REQUEST and 10

    // Send response depending on the balance

    if ((balance - charge_req) < 10)
    {
      // INSUFFICIENT BALANCE
      snprintf(sendbuffer, sizeof(sendbuffer), "MOVIE_REJECTED\r\nCURRENT_BALANCE: % d\r\n\r\n", balance);

      // Send response and wait for top up request
      ssize_t numBytesSent = send(clntSock, sendbuffer, strlen(sendbuffer), 0);
      if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

      // Inform user of the current situation
      printf("Insufficient balance: %d . Incoming top-up request", balance);
      printf("\n");

      // Receive top up request
      while ((numBytes = recv(clntSock, recvbuffer, BUFSIZE - 1, 0)) > 0)
      {
        recvbuffer[numBytes] = '\0';
        fputs(recvbuffer, stdout);
        if (strstr(recvbuffer, "\r\n\r\n") > 0)
          break;
      }

      sscanf(recvbuffer, "%s %d", discard2, &top_up); // Receive TOP_UP and integer value

      // Update balance and report that to the user before closing
      balance = balance + top_up;
      printf("Balance updated! Current balance is: %d", balance);
      printf("\n");

      break;
    }
    else
    {
      // SUFFICIENT BALANCE
      balance = balance - charge_req;

      snprintf(sendbuffer, sizeof(sendbuffer), "MOVIE_GRANTED\r\nCURRENT_BALANCE: % d\r\n\r\n", balance);

      // Send response and close connection
      ssize_t numBytesSent = send(clntSock, sendbuffer, strlen(sendbuffer), 0);
      if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

      // Inform user of the current situation
      printf("\nMovie rent granted. Final balance: %d", balance);
      printf("\n");

      break;
    }

    // Reset variables
    charge_req = 0;
    strcpy(discard1, "");
    strcpy(discard2, "");
    close(clntSock); // Close client Socket
  }
  // NOT REACHED
}