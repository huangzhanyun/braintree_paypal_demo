<?php
include_once '../includes/braintree_init.php';

$request = $_REQUEST;

$payment_json = private_decrypt($request['payment_data']);

if (!isset($payment_json) || $payment_json == '') {
    errorPage('无效支付参数');
}
$payment = json_decode($payment_json, true);

$token = $gateway->ClientToken()->generate();
$smarty->assign('token', $token);
$smarty->assign('payment', $payment);
$smarty->assign('payment_data', $request['payment_data']);
$smarty->display('pay.html');