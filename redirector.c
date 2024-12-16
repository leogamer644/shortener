#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <microhttpd.h>

#define PORT 8080
#define MAX_URL_LENGTH 2048
#define MAX_SHORT_LENGTH 64

// Function to find the long URL for a given short code
const char *find_long_url(const char *short_code) {
    static char long_url[MAX_URL_LENGTH];
    FILE *file = fopen("urls.txt", "r");
    if (!file) {
        perror("Error opening urls.txt");
        return NULL;
    }

    char short_url[MAX_SHORT_LENGTH], url[MAX_URL_LENGTH];
    while (fscanf(file, "%s %s", short_url, url) != EOF) {
        if (strcmp(short_url, short_code) == 0) {
            fclose(file);
            strncpy(long_url, url, MAX_URL_LENGTH);
            return long_url;
        }
    }

    fclose(file);
    return NULL;
}

// HTTP request handler
static int handle_request(void *cls, struct MHD_Connection *connection,
                          const char *url, const char *method,
                          const char *version, const char *upload_data,
                          size_t *upload_data_size, void **con_cls) {
    // Only handle GET requests
    if (strcmp(method, "GET") != 0) {
        return MHD_NO;
    }

    // Skip the leading "/" in the URL
    const char *short_code = url + 1;

    // Find the long URL
    const char *long_url = find_long_url(short_code);

    if (long_url) {
        // Redirect to the long URL
        struct MHD_Response *response = MHD_create_response_from_buffer(0, NULL, MHD_RESPMEM_PERSISTENT);
        MHD_add_response_header(response, "Location", long_url);
        int ret = MHD_queue_response(connection, MHD_HTTP_FOUND, response);
        MHD_destroy_response(response);
        return ret;
    } else {
        // Respond with 404 Not Found
        const char *not_found = "404 Not Found\n";
        struct MHD_Response *response = MHD_create_response_from_buffer(strlen(not_found),
                                                                        (void *)not_found, MHD_RESPMEM_PERSISTENT);
        int ret = MHD_queue_response(connection, MHD_HTTP_NOT_FOUND, response);
        MHD_destroy_response(response);
        return ret;
    }
}

int main() {
    printf("Starting URL shortener on port %d...\n", PORT);

    // Start the HTTP server
    struct MHD_Daemon *server = MHD_start_daemon(MHD_USE_SELECT_INTERNALLY, PORT, NULL, NULL,
                                                 &handle_request, NULL, MHD_OPTION_END);
    if (!server) {
        fprintf(stderr, "Failed to start server on port %d.\n", PORT);
        return 1;
    }

    // Keep the server running until interrupted
    printf("Server running. Press Ctrl+C to stop.\n");
    getchar();

    // Stop the server
    MHD_stop_daemon(server);
    return 0;
}