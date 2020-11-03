const admin = require('firebase-admin');

exports.addObservation = async function(data) {
  if (!data.utctime) {
    throw new Error('utctime field is empty');
  }
  const date = new Date(data.utctime * 1000).toISOString();
  const doc = admin
    .firestore()
    .collection('observations')
    .doc(date);

  if ((await doc.get()).exists) {
    console.warn(`Observation ${date} already exists`);
  } else {
    console.info('Adding observation to Firestore', date);
    return doc.create(data);
  }
};
