// Node process that polls WifiLogger (wflexp.json) to insert observations into Firestore

const fetch = require('node-fetch');
const api = require('../functions/api.js');

const interval = 5 * 60 * 1000;
const url = 'http://192.168.1.105/wflexp.json';
console.log(`Polling ${url} every ${interval / 1000} secs`);

async function getData() {
  const data = await (await fetch(url)).json();
  await api.addObservation(data);
}

setInterval(getData, interval);
