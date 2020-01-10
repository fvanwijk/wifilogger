import fetch from 'node-fetch';

const url = 'http://192.168.2.115/wflexp.json';
async function getData() {
  console.log(`Polling ${url}`);
  const data = await (await fetch(url)).json();
  //console.log(data)
}

setInterval(getData, 1000);

