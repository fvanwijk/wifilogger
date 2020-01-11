import express from 'express';
const app = express()
const port = 8080

app.use(express.json());
app.use((req, res, next) => {
  console.log('Called API')
  next();
})

const log = (req, res) => {
  console.log(req.body);
  return res.send('WiFiLogger!');
}

app.all('/', log)

app.listen(port, () => console.log(`Example app listening on port ${port}!`))
