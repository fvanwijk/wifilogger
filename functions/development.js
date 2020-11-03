const functions = require('firebase-functions');
const { addObservation } = require('./api');

const getUtcTime = str => Math.round(+new Date(str) / 1000);

exports.addTestObservations = functions
  .region('europe-west1')
  .https.onRequest(async function addTestObservations(req, res) {
    const baseObservation = {
      stnname: 'DinkelLogger',
      stnmod: 16,
      ver: 3.83,
      mac: '4C:11:AE:6D:D2:10',
      apmac: '4C:11:AE:6D:D2:11',
      ip: '192.168.1.105',
      ssid: 'DinkelWiFi',
      rssi: -56,
      wifimod: 0,
      lastboot: 1598914062,
      uptime: 5440351,
      wflver: '2.25',
      loctime: 1604357701,
      utctime: 1604354101,
      tzone: 21,
      units: 191,
      conlati: 522,
      conlongi: 45,
      wfllati: -300.0,
      wfllongi: -300.0,
      tempout: '54.4',
      humout: '71',
      tempin: '77.2',
      humin: '50',
      windspd: '5.0',
      winddir: '257',
      windavg2: '5.7',
      windavg10: '4.8',
      gust: '15.0',
      gustdir: '180',
      bar: '29.974',
      bartr: '60',
      dew: '45',
      cdew: '45.2',
      chill: '53',
      heat: '54',
      thsw: '---',
      uv: '---',
      solar: '---',
      rainr: '0.00000',
      storm: '0.17323',
      rain15: '0.00000',
      rain1h: '0.00000',
      raind: '0.03937',
      rain24: '0.04724',
      rainmon: '0.08661',
      rainyear: '28.30703',
      etday: '0.000',
      etmon: '0.00',
      etyear: '0.00',
      xt: ['---', '---', '---', '---', '---', '---', '---'],
      xlt: ['---', '---', '---', '---'],
      xst: ['---', '---', '---', '---'],
      xh: ['---', '---', '---', '---', '---', '---', '---'],
      xsm: ['---', '---', '---', '---'],
      xlw: ['---', '---', '---', '0'],
      bat: '4.75',
      trbat: '0',
      foreico: '6',
      forrule: '75',
      sunrt: '7:42',
      sunst: '17:10',
      hlbar: ['29.615', '29.977', '3:51', '22:48', '29.977', '29.615', '30.968', '29.008'],
      hlwind: ['---', '22.0', '---', '15:30', '27.0', '---', '37.0', '---'],
      hltempin: ['75.9', '78.0', '6:54', '19:03', '78.0', '74.9', '93.3', '64.0'],
      hlhumin: ['50', '54', '22:30', '3:31', '54', '43', '60', '19'],
      hltempout: ['54.4', '65.1', '22:44', '11:49', '65.1', '50.7', '98.1', '31.5'],
      hlhumout: ['71', '94', '22:51', '0:01', '95', '71', '98', '20'],
      hldew: ['45', '62', '22:51', '0:00', '62', '45', '72', '15'],
      hlchill: ['54', '---', '22:22', '---', '---', '51', '---', '28'],
      hlheat: ['---', '66', '---', '3:26', '66', '---', '103', '---'],
      hlthsw: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlsolar: ['---', '0', '---', '---', '0', '---', '0', '---'],
      hluv: ['---', '0.0', '---', '---', '0.0', '---', '0.0', '---'],
      hlrainr: ['0.000', '0.937', '---', '12:48', '0.937', '---', '7.961', '---'],
      hlxt0: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxt1: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxt2: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxt3: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxt4: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxt5: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxt6: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxh0: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxh1: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxh2: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxh3: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxh4: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxh5: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxh6: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxst0: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxst1: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxst2: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxst3: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxlt0: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxlt1: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxlt2: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxlt3: ['---', '---', '---', '---', '---', '---', '---', '---'],
      hlxsm0: ['---', '---', '0:00', '---', '---', '---', '---', '---'],
      hlxsm1: ['---', '---', '0:00', '---', '---', '---', '---', '---'],
      hlxsm2: ['---', '---', '0:00', '---', '---', '---', '---', '---'],
      hlxsm3: ['---', '---', '0:00', '---', '---', '---', '---', '---'],
      hlxlw0: ['---', '---', '0:00', '---', '---', '---', '---', '---'],
      hlxlw1: ['---', '---', '0:00', '---', '---', '---', '---', '---'],
      hlxlw2: ['---', '---', '0:00', '---', '---', '---', '---', '---'],
      hlxlw3: ['---', '---', '0:00', '---', '---', '---', '---', '---']
    };
    try {
      const data = [
        ['2020-11-02 22:00', 54.4],
        ['2020-11-02 22:05', 58],
        ['2020-11-02 22:10', 52],
        ['2020-11-03 22:00', 44.4],
        ['2020-11-03 22:05', 48],
        ['2020-11-03 22:10', 42]
      ];

      await Promise.all(
        data.map(
          (d, i) =>
            new Promise(resolve =>
              setTimeout(resolve(addObservation({ utctime: getUtcTime(d[0]), tempout: d[1] })), i * 1000)
            )
        )
      );

      res.json({ resultCount: data.length });
    } catch (e) {
      console.log(e);
      res.json({ error: e.message });
    }
  });

exports.localBackups = async (req, res) => {
  const result = {};
  db.collection('observations')
    .get()
    .then(querySnapshot => {
      querySnapshot.forEach(doc => {
        result[doc.id] = doc.data();
      });
      const itemCount = Object.keys(result).length;
      if (!itemCount) {
        console.log('Empty backup. Are you sure prod db is connected?');
      } else {
        console.log(`Backing up ${itemCount} observations`);
      }

      fs.writeFile('./backup.json', JSON.stringify(result, null, 2), err => {
        if (err) {
          res.sendStatus(500);
        }
        console.log('Backupped in backup.json');
        res.sendStatus(200);
      });
    });
};

exports.migrateMonth = async (req, res) => {
  const month = req.params.month;
  const weather = require(`./weather_2020-${month}.json`);

  const data = weather.map(d => {
    return {
      apmac: '4C:11:AE:6D:D2:11',
      bar: d.MeanSeaLevelPressure_InchOfMercury,
      // bartr: '0',
      // bat: '4.75',
      // cdew: '52.8',
      // chill: '62',
      conlati: d.Latitude * 10,
      conlongi: d.Longitude * 10,
      dew: d.DewPointTemperature_Fahrenheit,
      // etday: '0.000',
      // etmon: '0.00',
      // etyear: '0.00',
      // foreico: '6',
      // forrule: '44',
      gust: d.WindGust_MilePerHour,
      gustdir: d.WindGustDirection,
      // heat: '62',
      // humin: '37',
      humout: d.RelativeHumidity,
      ip: '192.168.1.105',
      // lastboot: 1598914062,
      loctime: +new Date(d.ReportStartDateTime + 2 * 3600) / 1000,
      mac: '4C:11:AE:6D:D2:10',
      // rain15: '0.00000',
      // rain1h: '0.00000',
      // rain24: '0.00000',
      // raind: '0.00000',
      // rainmon: '0.00000',
      rainr: d.RainfallAmount_Inch, // was 0.000000
      // rainyear: '20.75586',
      rssi: -47,
      // solar: null,
      ssid: 'DinkelWiFi',
      stnmod: 16,
      stnname: 'DinkelLogger',
      // storm: '0.00000',
      // sunrt: '6:54',
      // sunst: '20:29',
      // tempin: '81.1',
      tempout: d.DryBulbTemperature_Fahrenheit,
      thsw: null,
      // trbat: '0',
      tzone: 21,
      // units: 191,
      // uptime: 52044,
      utctime: +new Date(d.ReportStartDateTime) / 1000,
      // uv: null,
      ver: 3.83,
      wfllati: -300,
      wfllongi: -300,
      wflver: '2.25',
      wifimod: 0,
      // windavg10: '1.1',
      // windavg2: '0.4',
      winddir: d.WindDirection,
      windspd: d.WindSpeed_MilePerHour,
      reimported: true
    };
  });

  try {
    const promises = data.map(obs => addObservation(obs));
    await Promise.all(promises);
    res.sendStatus(200);
  } catch (e) {
    console.log(e);
    res.sendStatus(500);
  }
};
