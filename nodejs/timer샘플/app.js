const WebSocket = require('ws');
const redis = require('redis');
const wss = new WebSocket.Server({ port: 5555 });
const cron = require('node-cron');
const request = require('request');
const {promisify} = require('util');
require('date-utils');

var subscriber = redis.createClient({ host: "127.0.0.1", port: 6379, password: "N84ac6" });
var client = redis.createClient({ host: "127.0.0.1", port: 6379, password: "N84ac6" });

wss.on('connection', async function connection(ws, req) {
  const clientIp = req.connection.remoteAddress || req.headers['x-forwarded-for'];
  console.log(`Websocket client(${clientIp}) connected!!`);
});

const broadcastTime = () => {
  const retMsg = {
    channel: "timer",
    message: new Date().toFormat('YYYY-MM-DD HH24:MI:SS')
  };
  
  wss.clients.forEach((client, index) => {
    if (client.readyState === WebSocket.OPEN) {
      client.send(JSON.stringify(retMsg));
    }
  });
}

const getAsync = promisify(client.get).bind(client);
const existsAsync = promisify(client.exists).bind(client);
const setAsync = promisify(client.set).bind(client);

const chkLoginMb = async () => {
  const members = await getAsync('loingMb');
  console.log('members:', JSON.stringify(members));
  
  const objMemberArr = JSON.parse(members);
  let newMemberArr = [];
  if (typeof objMemberArr === 'object') {
    for (const member of objMemberArr) {
      let exist = await existsAsync(member);
      if (exist === 1) {
        newMemberArr.push(member);        
      }
    }
    console.log('new member:', JSON.stringify(newMemberArr));
    setAsync('loingMb', JSON.stringify(newMemberArr));
  }
}

setInterval(() => {
  // if(time.getSeconds() === 0){
  //     request('http://api.allnew.io/SiteSet/BatCntReset',function (error, response, body) {});
  // }
  broadcastTime();
  chkLoginMb();
}, 1000);

const cronCallback = () => {
  console.log(`[${new Date().toFormat('YYYY-MM-DD HH24:MI:SS')}] REST API REQUEST`);
  request('http://api.nssys.kr/SiteSet/site_set', (error, response, body) => {
    if (error) {
      console.log(`[rest api request problem] url: api.allnew.io/SiteSet/site_set, err: ${error}`);
      return;
    } else if (response.statusCode !== 200) {
      console.log(`[rest api response code] ${response.statusCode}`);
      return;
    }

    // if (typeof response === 'object') {
    //   console.log(`response: ${JSON.stringify(response, null, 2)}`);
    // }
    console.log(`[response] statusCode: ${response.statusCode}, method: ${response.request.method}, host: ${response.request.uri.host}`)
  });
}

//cron.schedule('*/1 * * * *', function () {
cronCallback();
cron.schedule('*/30 * * * *', cronCallback);

// client 객체가 메시지를 받으면 호출되는 함수
subscriber.on('message', (channel, message) => {
  try {
    const msg = JSON.parse(message);
    if (typeof msg !== 'object') {
      console.log(`[JSON parse error] origin msg: ${message}, chennel: ${channel}`);
      return;
    }

    if (channel === "new_batting") {
      client.get(msg, (err, val) => {
        if (err) {
          console.log(`redis client get err: ${err}`);
        } else {
          console.log(`redis get[${msg}]: ${val}`);
        }
      });
    }

    const retMsg = {
      channel: channel,
      message: msg
    };
    const retData = JSON.stringify(retMsg);

    wss.clients.forEach((client, index) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(retData);
      }
    });
  } catch (e) {
    console.log(`[Exception occured] ${e}`);
    return;
  }
});

//resetLimitData();
subscriber.subscribe("hntest");
subscriber.subscribe("site_chk_in");//사이트 기늡 정검 기능
subscriber.subscribe("game_limit");//판정기준 t_limit내용 get 도 똑같은 game_limit로 내용 확인 가능
subscriber.subscribe("siteSet");//판정기준 t_limit내용 get 도 똑같은 game_limit로 내용 확인 가능
subscriber.subscribe("game_result");//게임 결과 및 판정결과
subscriber.subscribe("new_batting");//새로운 배팅이 있을때
