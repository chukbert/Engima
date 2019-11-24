<?php

function generateVirtualAccount($account)
{
    $sc = new SoapClient("http://13.229.224.101:8080/engima/WSBank?wsdl");
    $params = array('arg0' => $account);
    $result = $sc->__soapCall('generateVA', array('parameters' => $params));
    return $result;
}

function checkTransactionExist($account, $amount, $start, $end)
{
    $sct = new SoapClient("http://13.229.224.101:8080/engima/WSBank?wsdl");
    $params = array('arg0' => $account, 'arg1' => $amount, 'arg2' => $start, 'arg3' => $end);
    $result = $sct->__soapCall('checkTransaction', array('parameters' => $params));
    return $result;
}

// $resp = generateVA(1);
// $resp = checkTransaction(2, 410, "2019-11-23 18:16:00", "2019-11-23 18:17:00");
// var_dump($resp);
