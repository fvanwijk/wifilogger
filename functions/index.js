const admin = require('firebase-admin');
const functions = require('firebase-functions');
const { Logging } = require('@google-cloud/logging');

admin.initializeApp({
  credential: admin.credential.applicationDefault()
});

const db = admin.firestore();
const observations = db.collection('observations');

function addObservation(data) {
  const date = new Date(data.utctime * 1000);
  return observations.doc(date.toISOString()).create(data);
}

const METADATA = {
  resource: {
    type: 'cloud_function',
    labels: {
      function_name: 'storeObservation',
      region: 'europe-west1'
    }
  }
};

const logging = new Logging();
const log = logging.log('wifilogger');

exports.storeObservation = functions.region('europe-west1').https.onRequest(async (req, res) => {
  console.log('Trying to log observation');
  try {
    await addObservation(req.body);
    res.json(req.body);
  } catch (e) {
    console.error('Could not store observation (console.error)');
    log.write(
      log.entry(METADATA, { event: 'store', value: req.body, message: 'Error storing observation (logger api)' })
    );
    res.status(500).send('Something went wrong');
  }
});
