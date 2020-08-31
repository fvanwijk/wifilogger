const admin = require('firebase-admin');
const functions = require('firebase-functions');
const { Logging } = require('@google-cloud/logging');

admin.initializeApp({
  credential: admin.credential.applicationDefault()
});

const db = admin.firestore();
const observations = db.collection('observations');

function addObservation(data) {
  console.log(data);
  if (!data.utctime) {
    throw new Error('utctime field is empty');
  }
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
  },
  severity: 500
};

const logging = new Logging();
const log = logging.log('wifilogger');

// PUT observation to this endpoint and it will be stored in the Observations collection on FrreStore
exports.storeObservation = functions.region('europe-west1').https.onRequest(async (req, res) => {
  console.log('Trying to log observation');
  try {
    await addObservation(req.body);
    console.log('Success', req.method);
    const content = '0\r\n#WL*';
    res.setHeader('Content-Length', content.length);
    res.setHeader('Content-Type', 'text/html');
    res.setHeader('Connection', 'close');
    res.end(content);
  } catch (e) {
    //try {
    // console.error('Could not store observation (console.error)');
    //   log.write(
    //     log.entry(METADATA, { event: 'store', value: req.body, message: 'Error storing observation (logger api)' })
    //   );
    // } catch (e) {
    console.log('oeps', e);
    //}
    res.status(500).send('Something went wrong');
  }
});
