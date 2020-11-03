const admin = require('firebase-admin');

admin.initializeApp({ projectId: 'Test' });
const db = admin.firestore();

const res = db
  .collection('maxTemperatures')
  .where('maxTemperature', '==', 71.1)
  .get()
  .then(ss => {
    console.log('Result count', ss.size);
    ss.forEach(d => console.log(d.data()));
  })
  .catch(e => {
    console.log('oeps', e);
  });
