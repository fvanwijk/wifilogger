const fs = require('fs');
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
// Disabled for nw because every can invoke this fn on prod
// .get('/migrate/:month', async (req, res) => {
//   const month = req.params.month;
//   const weather = require(`./weather_2020-${month}.json`);
//
//   const data = weather.map(d => {
//     return {
//       apmac: '4C:11:AE:6D:D2:11',
//       bar: d.MeanSeaLevelPressure_InchOfMercury,
//       // bartr: '0',
//       // bat: '4.75',
//       // cdew: '52.8',
//       // chill: '62',
//       conlati: d.Latitude * 10,
//       conlongi: d.Longitude * 10,
//       dew: d.DewPointTemperature_Fahrenheit,
//       // etday: '0.000',
//       // etmon: '0.00',
//       // etyear: '0.00',
//       // foreico: '6',
//       // forrule: '44',
//       gust: d.WindGust_MilePerHour,
//       gustdir: d.WindGustDirection,
//       // heat: '62',
//       // humin: '37',
//       humout: d.RelativeHumidity,
//       ip: '192.168.1.105',
//       // lastboot: 1598914062,
//       loctime: +new Date(d.ReportStartDateTime + 2 * 3600) / 1000,
//       mac: '4C:11:AE:6D:D2:10',
//       // rain15: '0.00000',
//       // rain1h: '0.00000',
//       // rain24: '0.00000',
//       // raind: '0.00000',
//       // rainmon: '0.00000',
//       rainr: d.RainfallAmount_Inch, // was 0.000000
//       // rainyear: '20.75586',
//       rssi: -47,
//       // solar: null,
//       ssid: 'DinkelWiFi',
//       stnmod: 16,
//       stnname: 'DinkelLogger',
//       // storm: '0.00000',
//       // sunrt: '6:54',
//       // sunst: '20:29',
//       // tempin: '81.1',
//       tempout: d.DryBulbTemperature_Fahrenheit,
//       thsw: null,
//       // trbat: '0',
//       tzone: 21,
//       // units: 191,
//       // uptime: 52044,
//       utctime: +new Date(d.ReportStartDateTime) / 1000,
//       // uv: null,
//       ver: 3.83,
//       wfllati: -300,
//       wfllongi: -300,
//       wflver: '2.25',
//       wifimod: 0,
//       // windavg10: '1.1',
//       // windavg2: '0.4',
//       winddir: d.WindDirection,
//       windspd: d.WindSpeed_MilePerHour,
//       reimported: true
//     };
//   });
//
//   try {
//     const promises = data.map(obs => addObservation(obs));
//     await Promise.all(promises);
//     res.sendStatus(200);
//   } catch (e) {
//     console.log(e);
//     res.sendStatus(500);
//   }
// })
// .get('/local-backup', async (req, res) => {
//   const result = {};
//   observations.get().then(querySnapshot => {
//     querySnapshot.forEach(doc => {
//       result[doc.id] = doc.data();
//     });
//     const itemCount = Object.keys(result).length;
//     if (!itemCount) {
//       console.log('Empty backup. Are you sure prod db is connected?');
//     } else {
//       console.log(`Backing up ${itemCount} observations`);
//     }
//
//     fs.writeFile('./backup.json', JSON.stringify(result, null, 2), err => {
//       if (err) {
//         res.sendStatus(500);
//       }
//       console.log('Backupped in backup.json');
//       res.sendStatus(200);
//     });
//   });
// });

// PUT observation to this endpoint and it will be stored in the Observations collection on FireStore
// Note that authorization is currently disabled, so anyone can call this endpoint and write to the database
exports.storeObservation = functions.region('europe-west1').https.onRequest(app);

// Update the collection with max temperatures per day based on single observations
exports.updateMaxTemperature = functions
  .region('europe-west1')
  .firestore.document('observations/{date}')
  .onWrite(async (change, context) => {
    const dateString = new Date(context.params.date).toISOString().slice(0, 10);

    const today = new Date(dateString);
    const tomorrow = new Date(dateString);
    tomorrow.setMinutes(59, 59, 999);
    tomorrow.setHours(23);

    return admin
      .firestore()
      .collection('observations')
      .where('utctime', '>', +today / 1000)
      .where('utctime', '<', +tomorrow / 1000)
      .get()
      .then(querySnapshot => {
        const maxTemperature = Math.max(...querySnapshot.docs.map(documentSnapshot => documentSnapshot.data().tempout));

        console.log('Set max temperature', `maxTemperatures/${dateString}`, { date: dateString, maxTemperature });
        return admin
          .firestore()
          .doc(`maxTemperatures/${dateString}`)
          .set({ date: dateString, maxTemperature });
      });
  });
