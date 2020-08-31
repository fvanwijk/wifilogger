# WiFiLogger API

This repository contains some NodeJS code to insert Davis Vantage Pro2 observations into a Firestore database.

A [WiFiLogger](http://www.wifilogger.net) is required, which needs to call the Firestore HTTP function endpoint.
The function inserts the request body in the database and uses the `utctime` field to determine a unique document ID (ISO string).

Alternatively I created some experimenting code to run as a simple Express server, for example on a Raspberry Pi. See src directory.
This server connects directly to Firestore.
I use it to see if WiFiLogger is able to connect through local network.

## How to run

To install dependencies, run in project root and functions dir:

```shell script
npm install
```

Install firebase tooling:

```shell script
npm install -g firebase-tooling
```

Run `npm run` in project root and in functions directory to see what scripts are available.

Set `GOOGLE_APPLICATION_CREDENTIALS` environment variable to authenticate locally with Google Service Account to Firebase Admin SDK. 
