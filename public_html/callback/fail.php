<?php
/**
 * Function:  支付失败回调
 * User: YUN
 * Date: 2018/10/27 09:20
 * Description:
 */

$config = include 'config.php';

$data = $_POST['data'];

$pub_key = openssl_pkey_get_public($config['public_key']);
$data_stream = base64_decode($data);
openssl_public_decrypt($data_stream, $decrypt, $pub_key);
$result = json_decode( $decrypt, true );
echo '<pre>';
print_r($result);
print_r($_POST);
