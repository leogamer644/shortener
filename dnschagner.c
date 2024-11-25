#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <curl/curl.h>

#define URLS_FILE "urls.txt"
#define CONFIG_FILE "api_zone.txt"
#define DOMAIN "leogamer644.com"

// Function to read API token and zone ID from the config file
int read_config(char *api_token, char *zone_id) {
    FILE *file = fopen(CONFIG_FILE, "r");
    if (file == NULL) {
        perror("Failed to open config file");
        return 1;
    }

    char line[256];
    while (fgets(line, sizeof(line), file)) {
        if (strncmp(line, "API_TOKEN=", 10) == 0) {
            strcpy(api_token, line + 10);
            api_token[strcspn(api_token, "\n")] = '\0';  // Remove newline
        } else if (strncmp(line, "ZONE_ID=", 8) == 0) {
            strcpy(zone_id, line + 8);
            zone_id[strcspn(zone_id, "\n")] = '\0';  // Remove newline
        }
    }

    fclose(file);
    return 0;
}

// Function to create a CNAME record on Cloudflare
void create_cname_record(const char *short_code, const char *long_url, const char *api_token, const char *zone_id) {
    CURL *curl;
    CURLcode res;
    struct curl_slist *headers = NULL;
    char data[1024];
    char url[1024];

    // Prepare the payload
    snprintf(data, sizeof(data),
             "{\"type\":\"CNAME\",\"name\":\"%s.%s\",\"content\":\"%s\",\"ttl\":120,\"proxied\":false}",
             short_code, DOMAIN, DOMAIN);

    // Construct the API endpoint URL
    snprintf(url, sizeof(url), "https://api.cloudflare.com/client/v4/zones/%s/dns_records", zone_id);

    // Initialize CURL
    curl_global_init(CURL_GLOBAL_DEFAULT);
    curl = curl_easy_init();

    if (curl) {
        // Set up the headers
        headers = curl_slist_append(headers, "Content-Type: application/json");
        char auth_header[512];
        snprintf(auth_header, sizeof(auth_header), "Authorization: Bearer %s", api_token);
        headers = curl_slist_append(headers, auth_header);

        // Set CURL options
        curl_easy_setopt(curl, CURLOPT_URL, url);
        curl_easy_setopt(curl, CURLOPT_HTTPHEADER, headers);
        curl_easy_setopt(curl, CURLOPT_POSTFIELDS, data);

        // Perform the API request
        res = curl_easy_perform(curl);

        // Handle the response
        if (res != CURLE_OK) {
            fprintf(stderr, "curl_easy_perform() failed: %s\n", curl_easy_strerror(res));
        } else {
            long response_code;
            curl_easy_getinfo(curl, CURLINFO_RESPONSE_CODE, &response_code);
            if (response_code == 200) {
                printf("DNS record created for %s -> %s\n", short_code, long_url);
            } else {
                printf("Error creating DNS record for %s. Response code: %ld\n", short_code, response_code);
            }
        }

        // Cleanup
        curl_easy_cleanup(curl);
        curl_slist_free_all(headers);
    }

    curl_global_cleanup();
}


int main() {
    char api_token[256];
    char zone_id[256];

    // Read API token and Zone ID from the config file
    if (read_config(api_token, zone_id) != 0) {
        return 1;
    }

    FILE *file = fopen(URLS_FILE, "r");
    if (file == NULL) {
        perror("Failed to open urls file");
        return 1;
    }

    char short_code[256];
    char long_url[1024];

    // Process each line of the file
    while (fscanf(file, "%s %s", short_code, long_url) != EOF) {
        create_cname_record(short_code, long_url, api_token, zone_id);
    }

    fclose(file);
    return 0;
}
