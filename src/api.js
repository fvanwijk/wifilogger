import admin from 'firebase-admin';

admin.initializeApp({
  credential: admin.credential.applicationDefault()
});

const db = admin.firestore();
const observations = db.collection('observations');

export async function addObservation(data) {
  try {
    const date = new Date(data.utctime * 1000);
    return await observations.doc(date.toISOString()).create(data);
  } catch (e) {
    console.log(e);
  }
}
