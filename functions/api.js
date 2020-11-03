const admin = require('firebase-admin');

exports.addObservation = function(data) {
  if (!data.utctime) {
    throw new Error('utctime field is empty');
  }
  const date = new Date(data.utctime * 1000);
  return admin
    .firestore()
    .collection('observations')
    .doc(date.toISOString())
    .create(data);
};
