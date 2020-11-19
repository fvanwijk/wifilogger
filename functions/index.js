const express = require('express');
const admin = require('firebase-admin');
const functions = require('firebase-functions');
const bodyParser = require('body-parser');
const { addDays } = require('date-fns');
const { Logging } = require('@google-cloud/logging');

const { addObservation } = require('./api');
const { addTestObservations, calcMaxTemperatures } = require('./development');

admin.initializeApp({
  credential: admin.credential.applicationDefault()
});

const METADATA = {
  resource: {
    type: 'cloud_function',
    labels: {
      function_name: 'storeObservation',
      region: 'europe-west1'
    }
  },
  severity: 500
};

const logging = new Logging();
const log = logging.log('wifilogger');

const apiApp = express();

const storeApp = express();
apiApp.use(bodyParser.json({ type: () => true, reviver: (key, value) => (value === '---' ? null : value) }));

// const app = express();
// app.use(bodyParser.json({ type: () => true, reviver: (key, value) => (value === '---' ? null : value) }));

// PUT observation to this endpoint and it will be stored in the Observations collection on FireStore
// Note that authorization is currently disabled, so anyone can call this endpoint and write to the database
storeApp.put('/storeObservation/', async (req, res) => {
  try {
    await addObservation(req.body);
    res.sendStatus(200);
  } catch (e) {
    console.error('Could not store observation (console.error)', e);
    log.write(
      log.entry(METADATA, { event: 'store', value: req.body, message: 'Error storing observation (logger api)' })
    );
    res.status(500).send('Something went wrong');
  }
});

// Disabled for now because everyone can invoke these functions on prod
// apiApp
//  .get('/addTestObservations/', addTestObservations)
//  .get('/calcMaxTemperatures/', calcMaxTemperatures);
//  .get('/migrate/:month', migrateMonth)
//  .get('/local-backup', localBackup);
const recalculateMaxTemperature = async (change, context) => {
  const dateString = new Date(context.params.date).toISOString().slice(0, 10);

  const today = new Date(dateString);
  const tomorrow = addDays(today, 1);

  // When observation is updated
  if (change.before.exists) {
    // Fetch all observations of day and recalculate max
    return admin
      .firestore()
      .collection('observations')
      .where('utctime', '>', +today / 1000)
      .where('utctime', '<', +tomorrow / 1000)
      .get()
      .then(querySnapshot => {
        const maxTemperature = Math.max(...querySnapshot.docs.map(documentSnapshot => documentSnapshot.data().tempout));
        const newDoc = { date: today, maxTemperature };

        console.info('[Update/Delete] Set max temperature', `maxTemperatures/${dateString}`, newDoc);
        return admin
          .firestore()
          .doc(`maxTemperatures/${dateString}`)
          .set(newDoc);
      });
    // New observation
  } else {
    // Set max to max of current max and new observation
    return admin
      .firestore()
      .doc(`maxTemperatures/${dateString}`)
      .get()
      .then(documentSnapshot => {
        const tempout = change.after.data().tempout;
        const maxTemperature = documentSnapshot.exists
          ? Math.max(documentSnapshot.data().maxTemperature, tempout)
          : tempout;
        const newDoc = { date: today, maxTemperature };
        console.info('[Create] Set max temperature', `maxTemperatures/${dateString}`, newDoc);

        return admin
          .firestore()
          .doc(`maxTemperatures/${dateString}`)
          .set(newDoc);
      });
  }
};

// All APIs
exports.api = functions.region('europe-west1').https.onRequest(apiApp);

// storeObservation app, to be moved into API app
exports.storeObservation = functions.region('europe-west1').https.onRequest(storeApp);

// Update the collection with max temperatures per day based on single observations
// Trigger when observation is added to collection
exports.updateMaxTemperature = functions
  .region('europe-west1')
  .firestore.document('observations/{date}')
  .onWrite(recalculateMaxTemperature);
