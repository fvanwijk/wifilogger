const admin = require('firebase-admin');
const functions = require('firebase-functions');

admin.initializeApp({
  credential: admin.credential.applicationDefault()
});

const db = admin.firestore();
const observations = db.collection('observations');

function addObservation(data) {
  const date = new Date(data.utctime * 1000);
  return observations.doc(date.toISOString()).create(data);
}

exports.storeObservation = functions.region('europe-west1').https.onRequest(async (req, res) => {
  try {
    await addObservation(req.body);
    res.json(req.body);
  } catch (e) {
    res.status(500).send(e);
  }
});
