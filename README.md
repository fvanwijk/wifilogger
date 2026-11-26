# WiFiLogger API

This repository contains some NodeJS code to insert Davis Vantage Pro2 observations into a Firestore database.

## Current status

The Firebase project remains on the free Spark plan. Its deployed functions
still use the unsupported Node.js 8 runtime and no longer receive observations.
The local functions have been updated to Node.js 22, but deploying them requires
the Blaze plan. There are no plans to upgrade from Spark to Blaze, so the
updated functions have not been deployed.

The Firestore database contains gaps in its observations. Historical backups,
including monthly weather data and a Firestore backup, are in the `functions`
directory; there were previous attempts to bulk import data within Spark's quota limits.
The station sends observations every 45 minutes and now uploads to WOW-BE.
Met Office WOW UK is being retired, so its historical observations need to be
exported before the service closes.

## Original design

A [WiFiLogger](http://www.wifilogger.net) calls the Firestore HTTP function endpoint.
The function inserts the request body in the database and uses the `utctime` field to determine a unique document ID (ISO string).

There is also a Firebase Function that triggers when an observation is added, to calculate the maxTemperature for the day.
This value is inserted into the maxTemperatures collection. This collection is required to stay within limits of the free Firebase plan.

Alternatively I created some experimenting code to run as a simple Express server, for example on a Raspberry Pi. See src directory.
This server connects directly to Firestore.
I use it to see if WiFiLogger is able to connect through local network.

## How to run

To install dependencies, run in project root and functions dir:

```shell script
npm install
```

The local Firebase functions target Node.js 22 (the newest supported runtime for
first-generation functions). Install the Firebase CLI:

```shell script
npm install -g firebase-tools
```

Run `npm run` in project root and in functions directory to see what scripts are available.

Set `GOOGLE_APPLICATION_CREDENTIALS` environment variable to authenticate locally with Google Service Account to Firebase Admin SDK.

The existing deployment scripts require the Blaze plan and cannot deploy
functions to the current Spark project.
