const express = require('express');
const admin = require('firebase-admin');
const functions = require('firebase-functions');
const bodyParser = require('body-parser');
const { Logging } = require('@google-cloud/logging');

admin.initializeApp({
  credential: admin.credential.applicationDefault()
});

const db = admin.firestore();
const observations = db.collection('observations');

function addObservation(data) {
  if (!data.utctime) {
    throw new Error('utctime field is empty');
  }
  const date = new Date(data.utctime * 1000);
  return observations.doc(date.toISOString()).set(data);
}

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

const app = express();
app.use(bodyParser.json({ type: () => true, reviver: (key, value) => (value === '---' ? null : value) }));

app.put('/', async (req, res) => {
  console.info('Trying to log observation');
  try {
    await addObservation(req.body);
    console.info('Successfully logged observation to Firestore');
    res.sendStatus(200);
  } catch (e) {
    console.error('Could not store observation (console.error)', e);
    log.write(
      log.entry(METADATA, { event: 'store', value: req.body, message: 'Error storing observation (logger api)' })
    );
    res.status(500).send('Something went wrong');
  }
});

// PUT observation to this endpoint and it will be stored in the Observations collection on FireStore
exports.storeObservation = functions.region('europe-west1').https.onRequest(app);
