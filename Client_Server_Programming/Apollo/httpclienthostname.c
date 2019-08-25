#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <netdb.h>
#include "Practical.h"

#define INDEX_PAGE "GET /index.html HTTP/1.0\r\n\r\n"

int main(int argc, char *argv[]) {
	char recvbuffer[BUFSIZE]; // I/O buffer
	char sendbuffer[BUFSIZE]; // Buffer for sending data to the server

  int numBytes = 0;

	if (argc < 3) // Test for correct number of arguments
    DieWithUserMessage("Parameter(s)",
        "<Server Address> <Server Port>");

	char *host = argv[1];     // First arg: server IP address (dotted quad)
	char *service = argv[2];

	int sock;

	struct addrinfo addrCriteria;												// Criteria for address match
	memset(&addrCriteria, 0, sizeof(addrCriteria));			// Zero out structure
	addrCriteria.ai_family = AF_UNSPEC;									// v4 or v6 is OK
	addrCriteria.ai_socktype = SOCK_STREAM;							// Only streaming sockets
	addrCriteria.ai_protocol = IPPROTO_TCP;							// Only TCP protocol


	// Get address(es)
	struct addrinfo *servAddr; // Holder for returned list of server addresses
	int rtnVal = getaddrinfo(host, service, &addrCriteria, &servAddr);
	if (rtnVal != 0) {
		DieWithUserMessage("getaddrinfo() failed", gai_strerror(rtnVal));
	}

	for (struct addrinfo *addr = servAddr; addr != NULL; addr = addr->ai_next) {
		// Create a reliable, stream socket using TCP
	 sock = socket(addr->ai_family, addr->ai_socktype, addr->ai_protocol);
		if (sock < 0) {
			continue;
		}

		if (connect(sock, addr->ai_addr, addr->ai_addrlen) == 0) {
			break;
		}
		close(sock);
		sock = -1;
	}

	freeaddrinfo(servAddr); // Free addrinfo allocated in getaddrinfo

	// clntSock is connected to a client!
  snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", INDEX_PAGE); //Create$
  ssize_t numBytesSent = send(sock, sendbuffer, strlen(sendbuffer), 0); //Se$

	if (numBytesSent < 0) {
      DieWithSystemMessage("send() failed");
    }

	while ((numBytes = recv(sock, recvbuffer, BUFSIZE - 1, 0)) > 0) {
		recvbuffer[numBytes] = '\0';    // Terminate the string!
		fputs(recvbuffer, stdout);      // Print the echo buffer
			/* Receive up to the buffer size (minus 1 to leave space for
				a null terminator) bytes from the sender */
		}
    if (numBytes < 0)
      DieWithSystemMessage("recv() failed");
		//    else if (numBytes == 0)
		//    DieWithUserMessage("recv()", "connection closed prematurely");

	fputc('\n', stdout); // Print a final linefe

	close(sock);
	exit(0);
}
