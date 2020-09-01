const http = require('http');
const api = require('../functions/api');

const port = 8080;
const host = '0.0.0.0';

const log = (req, res) => {
  console.log('Endpoint triggered');
  let body = [];
  req
    .on('data', chunk => {
      body.push(chunk);
    })
    .on('end', async () => {
      body = Buffer.concat(body).toString();

      if (body) {
        await api.addObservation(JSON.parse(body));
      }

      res.end(`${req.method} ${body}`);
    });
};

const server = http.createServer(log);

server.listen({ port, host }, err => {
  if (err) {
    return console.log('Something bad happened', err);
  }

  console.log(`Example app listening on port ${port}`);
});
