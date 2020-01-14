import fetch from 'node-fetch';
import { addObservation } from './api.js';

const interval = 5 * 60 * 1000;
const url = 'http://192.168.2.115/wflexp.json';
console.log(`Polling ${url} every ${interval / 1000} secs`);

async function getData() {
  const data = await (await fetch(url)).json();
  await addObservation(data);
}

setInterval(getData, interval);
