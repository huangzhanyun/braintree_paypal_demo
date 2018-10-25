<?php
$public_key = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArs825bTjoMRyEI19fDBP
r4SVdxIATatgwHSlz5gXT5H2QmofN2x1nal7BKO9G244XKKeYOaZH4KIrxLT+beU
FR0zzaQDBfh1N5aUKnn3tFsfVkZqbOXHMSUExdtNbijBZ53KFHQJz2ql1M7XzkhK
gwdFWEI5tNAd0tX7F5E39d1INzl+Vo3R31piLCPwrKegdjkmhFbHJ4+ZFiECjmQ5
r4pxQYxJWxZzU7xSOLeYLWIjLErTDn+gQQ7X+PqK7+O6XG/GQ+MXPjlPjnLIihiR
5Rr58Tn0YjNoYgpvJ4Rm4D211TlyoHdzYlNgUwbk/EXFpOEOyFR5DYhmjNhjCmGs
QwIDAQAB
-----END PUBLIC KEY-----';

$data = [
    'order_id' => date('YmdHis'),
    'amount' => '1.00',
];

$public_key = file_get_contents('../includes/public.key');

$public_key_res = openssl_pkey_get_public($public_key);
$data_json = json_encode($data);
openssl_public_encrypt($data_json, $encrypt, $public_key_res);
$pay_data = urlencode(base64_encode($encrypt));
?>
<html>
<meta charset="utf-8">
<link href="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet">
<body>
    <a href="pay.php?payment_data=<?php echo $pay_data;?>">支付订单</a>
</body>
</html>

