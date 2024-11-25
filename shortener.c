#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>

#define HASH_LENGTH 6
#define MAX_URL_LENGTH 2048
#define DATABASE_FILE "urls.txt"

// Function to generate a random alphanumeric string
void generate_short_url(char *short_url) {
    const char charset[] = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for (int i = 0; i < HASH_LENGTH; i++) {
        short_url[i] = charset[rand() % (sizeof(charset) - 1)];
    }
    short_url[HASH_LENGTH] = '\0';
}

// Retrieve a short URL from a long URL
int retrieve_short_url(const char *long_url, char *short_url) {
    FILE *file = fopen(DATABASE_FILE, "r");
    if (file == NULL) {
        perror("Failed to open database file");
        return 0;
    }

    char stored_short[HASH_LENGTH + 1];
    char stored_long[MAX_URL_LENGTH];
    while (fscanf(file, "%s %s", stored_short, stored_long) != EOF) {
        if (strcmp(stored_long, long_url) == 0) {
            strcpy(short_url, stored_short);
            fclose(file);
            return 1; // Found
        }
    }

    fclose(file);
    return 0; // Not found
}


void save_mapping(const char *short_url, const char *long_url) {
    FILE *file = fopen(DATABASE_FILE, "a"); // Open in append mode
    if (file == NULL) {
        perror("Failed to open database file");
        return;
    }

    // Write the mapping to the file
    if (fprintf(file, "%s %s\n", short_url, long_url) < 0) {
        perror("Failed to write to database file");
    }

    fflush(file); // Ensure the data is flushed to the file
    fclose(file); // Close the file
}

// Retrieve a long URL from a short URL
int retrieve_long_url(const char *short_url, char *long_url) {
    FILE *file = fopen(DATABASE_FILE, "r");
    if (file == NULL) {
        perror("Failed to open database file");
        return 0;
    }

    char stored_short[HASH_LENGTH + 1];
    char stored_long[MAX_URL_LENGTH];
    while (fscanf(file, "%s %s", stored_short, stored_long) != EOF) {
        if (strcmp(stored_short, short_url) == 0) {
            strcpy(long_url, stored_long);
            fclose(file);
            return 1; // Found
        }
    }

    fclose(file);
    return 0; // Not found
}
int main(int argc,char *argv[]) {
    srand(time(NULL)); // Seed for random number generation
    char *input_url = argv[1];
    char long_url[MAX_URL_LENGTH];
    char short_url[HASH_LENGTH + 1];

        // Check if the URL already exists
        if (retrieve_short_url(input_url, short_url)) {
            printf("Shortened URL: %s\n", short_url);
        } else {
            generate_short_url(short_url);
            save_mapping(short_url, input_url);
            printf("Shortened URL: %s\n", short_url);
        }
}