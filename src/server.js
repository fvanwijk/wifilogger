const http = require('http');
const port = 8080;

const log = (req, res) => {
  console.log(req.method, req.body);
  return res.send('WiFiLogger!');
};

const server = http.createServer(log);

server.listen(port, err => {
  if (err) {
    return console.log('Something bad happened', err);
  }

  console.log(`Example app listening on port ${port}`);
});
