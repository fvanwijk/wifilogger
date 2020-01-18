const functions = require('firebase-functions');

exports.storeObservation = functions.region('europe-west1').https.onRequest((req, res) => {
  res.send('Hello from Firebase!');
});
