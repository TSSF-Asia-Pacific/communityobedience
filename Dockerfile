FROM php:8.3-cli-alpine

# Install Node.js and npm via Alpine package manager
RUN apk add --no-cache nodejs npm yarn
