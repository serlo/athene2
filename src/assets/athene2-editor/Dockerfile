# Dockerfile for athene2-editor. requires athene2-editor buildfiles from https://github.com/serlo-org/athene2-editor to build and run.

FROM node:0.12.5

RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app
COPY . /usr/src/app

RUN npm install

ENTRYPOINT npm start

EXPOSE 7070