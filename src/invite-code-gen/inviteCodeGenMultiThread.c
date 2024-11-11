#include <stdio.h>
#include <stdbool.h>
#include <stdlib.h>
#include <sodium.h>
#include <pthread.h>

char serial[29];
pthread_mutex_t mutex;

char GenerateRandomCharacter() {
    const char characters[35] = "ABCDEFGHIJKLMNOPQRSTUVWXY0123456789";
    uint32_t randomIndex = randombytes_uniform(35);
    return characters[randomIndex];
}

int GenerateSerialKey() {
    uint8_t i = 0;
    for (i = 0; i < 29; i++) {
        if ((i + 1) % 6 == 0) {
            serial[i] = '-';
        } else {
            serial[i] = GenerateRandomCharacter();
        }
    }
    return 0;
}

bool ChecksumCalc() {
    uint32_t checksum = 0;
    uint32_t expectedChecksum = serial[25];
    uint8_t i = 0;
    for (i = 0; i < 25; i++) {
        if (i % 6 != 5) {
            checksum += serial[i];
        }
    }
    return checksum % 26 == (expectedChecksum - 'A');
}

void* GenerateAndCheckSerialKeys(void* arg) {
    int numToGen = *((int*)arg);
    for (int i = 0; i < numToGen; i++) {
        do {
            GenerateSerialKey();
        } while (!ChecksumCalc());

        pthread_mutex_lock(&mutex);
        FILE* file = fopen("invite_codes.sql", "a");
        if (file != NULL) {
            fprintf(file, "INSERT INTO invitecodes (invitecode) VALUES (\"%s\");\n", serial);
            fclose(file);
        }
        pthread_mutex_unlock(&mutex);
    }
    pthread_exit(NULL);
}

int main(int argc, char* argv[]) {
    if (argc != 3) {
        printf("Invalid number of arguments\n");
        printf("Usage: %s [number of threads] [number of valid serials to generate]\n", argv[0]);
        return 1;
    }

    char* inputNumThreads = argv[1];
    char* inputNumToGen = argv[2];
    int numThreads = atoi(inputNumThreads);
    int numToGen = atoi(inputNumToGen);

    if (numThreads <= 0 || numToGen <= 0) {
        printf("Invalid input: Please specify a valid number of threads and serials to generate!\n");
        return 1;
    }

    if (sodium_init() < 0) {
        printf("Couldn't initialize sodium library for cryptography! Exiting...\n");
        return 1;
    }

    pthread_t threads[numThreads];
    int thread_args[numThreads];
    pthread_mutex_init(&mutex, NULL);

    printf("Generating serial keys with %d threads... This might take a while\n", numThreads);

    for (int i = 0; i < numThreads; i++) {
        thread_args[i] = numToGen / numThreads; // Distribute work equally among threads
        if (i < numToGen % numThreads) {
            thread_args[i]++; // Handle any remainder
        }

        if (pthread_create(&threads[i], NULL, GenerateAndCheckSerialKeys, &thread_args[i]) != 0) {
            perror("Thread creation failed");
            return 1;
        }
    }

    for (int i = 0; i < numThreads; i++) {
        pthread_join(threads[i], NULL);
    }

    pthread_mutex_destroy(&mutex);
    return 0;
}

