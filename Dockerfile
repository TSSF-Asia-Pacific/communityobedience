FROM php:8.4-cli-alpine

RUN apk add --no-cache nodejs npm \
    && npm install -g corepack \
    && corepack enable
