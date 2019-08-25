#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include "Practical.h"
#include <unistd.h>
#include <netdb.h>

#define HELO        "HELO apollo.ict.ad.dit.ie"
#define MAIL_FROM   "MAIL FROM: <d18123298@mydit.ie>"
#define RCPT_TO     "RCPT TO: <d18123298@mydit.ie>"
#define DATA        "DATA"
#define MAIL        "From: DITBOT@dit.ie\r\nTo: d18123298@mydit.ie\r\nSubject: Junk Mail\r\n\r\nThis message has been originated for shits and giggles.\r\n."
#define QUIT        "QUIT"

int main(int argc, char *argv[])
{
    char recvbuffer[BUFSIZE]; // I/O buffer
    int numBytes = 0;
    char sendbuffer[BUFSIZE]; // Buffer for sending data

    if (argc < 3)
        DieWithUserMessage("Parameter(s)", "<Server Address> <Server Port>");

    char *host = argv[1];    // Server address/name
    char *service = argv[2]; // Server port/service
    char *getRequest = argv[3];
    int sock;

    struct addrinfo addCriteria;                    // Criteria for address match
    memset(&addCriteria, 0, sizeof(addCriteria));   // Zero out structure
    addCriteria.ai_family   = AF_UNSPEC;            // v4 or v6 is OK
    addCriteria.ai_socktype = SOCK_STREAM;          // Only streaming sockets
    addCriteria.ai_protocol = IPPROTO_TCP;          // Only TCP protocol

    // Get address(es)
    struct addrinfo *servAddr;                      // List of server addresses
    int rtnVal = getaddrinfo(host, service, &addCriteria, &servAddr);
    if (rtnVal != 0) 
        DieWithUserMessage("getaddrinfo() failed", gai_strerror(rtnVal));

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

    freeaddrinfo(servAddr);     // Free addrinfo allocated in getaddrinfo

    // Send request to open service
    snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", HELO);
    printf("%s\r\n", HELO);     // Print sent message
    ssize_t numBytesSent = send(sock, sendbuffer, strlen(sendbuffer), 0);
    strcpy(sendbuffer, "");     // Empty sendbuffer
    if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

    while ((numBytes = recv(sock, recvbuffer, BUFSIZE - 1, 0)) > 0)
    {
        recvbuffer[numBytes] = '\0';
        fputs(recvbuffer, stdout);
        if (strstr(recvbuffer, "\r\n"))
          break;
    }

    if (numBytes < 0)
        DieWithSystemMessage("recv() failed");

    fputc('\n', stdout);

    // Send mail_from information
    snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", MAIL_FROM);
    printf("%s\r\n", MAIL_FROM);     // Print sent message
    numBytesSent = send(sock, sendbuffer, strlen(sendbuffer), 0);
    strcpy(sendbuffer, "");     // Empty sendbuffer
    if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

    while ((numBytes = recv(sock, recvbuffer, BUFSIZE - 1, 0)) > 0)
    {
        recvbuffer[numBytes] = '\0';
        fputs(recvbuffer, stdout);
        if (strstr(recvbuffer, "\r\n"))
          break;
    }

    if (numBytes < 0)
        DieWithSystemMessage("recv() failed");

    fputc('\n', stdout);

    // Send rcpt_to information
    snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", RCPT_TO);
    printf("%s\r\n", RCPT_TO);     // Print sent message
    numBytesSent = send(sock, sendbuffer, strlen(sendbuffer), 0);
    strcpy(sendbuffer, "");     // Empty sendbuffer
    if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

    while ((numBytes = recv(sock, recvbuffer, BUFSIZE - 1, 0)) > 0)
    {
        recvbuffer[numBytes] = '\0';
        fputs(recvbuffer, stdout);
        if (strstr(recvbuffer, "\r\n"))
          break;
    }

    if (numBytes < 0)
        DieWithSystemMessage("recv() failed");

    fputc('\n', stdout);

    // Send DATA (just 'DATA')
    snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", DATA);
    printf("%s\r\n", DATA);     // Print sent message
    numBytesSent = send(sock, sendbuffer, strlen(sendbuffer), 0);
    strcpy(sendbuffer, "");     // Empty sendbuffer
    if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

    while ((numBytes = recv(sock, recvbuffer, BUFSIZE - 1, 0)) > 0)
    {
        recvbuffer[numBytes] = '\0';
        fputs(recvbuffer, stdout);
        if (strstr(recvbuffer, "\r\n"))
          break;
    }

    if (numBytes < 0)
        DieWithSystemMessage("recv() failed");

    fputc('\n', stdout);

    // Send actual mail
    snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", MAIL);
    printf("%s\r\n", MAIL);     // Print sent message
    numBytesSent = send(sock, sendbuffer, strlen(sendbuffer), 0);
    strcpy(sendbuffer, "");     // Empty sendbuffer
    if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

    while ((numBytes = recv(sock, recvbuffer, BUFSIZE - 1, 0)) > 0)
    {
        recvbuffer[numBytes] = '\0';
        fputs(recvbuffer, stdout);
        if (strstr(recvbuffer, "\r\n"))
          break;
    }

    if (numBytes < 0)
        DieWithSystemMessage("recv() failed");

    fputc('\n', stdout);

    // Quit
    snprintf(sendbuffer, sizeof(sendbuffer), "%s\r\n", QUIT);
    printf("%s\r\n", QUIT);     // Print sent message
    numBytesSent = send(sock, sendbuffer, strlen(sendbuffer), 0);
    strcpy(sendbuffer, "");     // Empty sendbuffer
    if (numBytesSent < 0)
        DieWithSystemMessage("send() failed");

    while ((numBytes = recv(sock, recvbuffer, BUFSIZE - 1, 0)) > 0)
    {
        recvbuffer[numBytes] = '\0';
        fputs(recvbuffer, stdout);
        if (strstr(recvbuffer, "\r\n"))
          break;
    }

    if (numBytes < 0)
        DieWithSystemMessage("recv() failed");

    fputc('\n', stdout);

    close(sock);
    exit(0);
}