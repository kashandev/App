<?php
/**
 * Created by PhpStorm.
 * User: Huzaifa
 * Date: 10-12-2019
 * Time: 11:17 AM
 */
include_once "config.php";

$cookie_jar = tempnam('/tmp','cookie');

$url1 = "http://demos.sartimsolutions.com/fas/api/authToken.php";
$data1 = array(
    'login_name' => 'hums_fas',
    'login_password' => '12345678',
);

$ch = curl_init($url1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data1));
$response = curl_exec($ch);
$response = json_decode($response);
curl_close($ch);
if($response->success && $response->token != '') {
    $url2 = "http://demos.sartimsolutions.com/fas/api/customer_receipt.php?token=".$response->token;
    $data2 = array(
        'customer_code' => '1002',
        'receipt_date' => '2019-12-12',
        'receipt_no' => 'RCP-0001',
        'receipt_amount' => '20000',
        'remarks' => 'Amount Received @ ' . date('YmdHis'),
    );


    $ch = curl_init($url2);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data2));
    $response = curl_exec($ch);
    $response = json_decode($response);
    curl_close($ch);
    d($response, true);
} else {
    echo $response->error;
    exit;
}
