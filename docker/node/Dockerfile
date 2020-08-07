
# Setup and build the client

FROM node:13.12.0-alpine as alpine

WORKDIR /app
COPY ./react/package*.json .
RUN npm install
COPY ./react/ .
CMD ["npm", "start"]

ENV DEBUG=*