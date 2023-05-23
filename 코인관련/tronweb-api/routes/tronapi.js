// require('dotenv').config();
require('dotenv').config({ path: '.env.test' });
var express = require('express');
const asyncify = require('express-asyncify');
var router = asyncify(express.Router());
const TronWeb = require('tronweb');
var config = process.env;
const tronWeb = new TronWeb(config.API_URL,config.API_URL);
const fromAddress = config.MAIN_ADDR; // 출발 주소
const privateKey = config.MAIN_PRIVATEKEY; // 출발 주소


const wrap = asyncFn => {
  return (async (req, res, next) => {
    try {
      return await asyncFn(req, res, next)
    } catch (error) {
      return next(error)
    }
  })
}

/* 메인 지갑의 코인 잔액 출력. */
router.post('/getBalance', wrap(async (req, res, next) => {
    address = req.body.address;
    try {
       const balance = await tronWeb.trx.getBalance(address);
       const retbln = await tronWeb.fromSun(balance);
       res.status(200).json({
           "balance" : retbln
       });
    } catch (err) {
       res.status(500).json({
           "Status" : false
       });
    }
}));

/* 메인 지갑에서 코인 내보내기. */
router.post('/senCoins', wrap(async (req, res, next) => {
    data = req.body;
    toAddress = req.body.address;
    sendAmount = tronWeb.toSun(req.body.amount);
    try {
        isAddr = await tronWeb.isAddress(toAddress);
        if(!isAddr){
            res.json({
                "Status" : false,
                'errorMsg' : "Not a valid address"
            });
        }else{
            const transaction = await tronWeb.transactionBuilder.sendTrx(toAddress, sendAmount, fromAddress);
            const signedTransaction = await tronWeb.trx.sign(transaction, privateKey);
            const result = await tronWeb.trx.sendRawTransaction(signedTransaction);
            res.status(200).json({
                "Status" : true,
                'retData' : result
            });
        }
    } catch (err) {
        res.status(500).json({
            "Status" : false,
            "errorMsg" : "Insufficient Balance"
        });
    }
}));

/* 새지갑 생성. */
router.get('/createWallet', wrap(async (req, res, next) => {
   const newWallet = await tronWeb.createAccount();
   const {privateKey,publicKey,address} = newWallet;
   res.status(200).json({
       "privateKey" : privateKey,
       "publicKey" : publicKey,
       "address" : address
   });
}));

/* 지갑의 자세한 정보 확인*/
router.post('/getAccount', wrap(async (req, res, next) => {
    data = req.body;
    const account = await tronWeb.trx.getAccount(req.body.address);
    res.status(200).json(account);
}));

/* 계정의 자원 조회*/
router.post('/getAccountResources', wrap(async (req, res, next) => {
    data = req.body;
    const account = await tronWeb.trx.getAccountResources(req.body.address);
    res.status(200).json(account);
}));

module.exports = router;
