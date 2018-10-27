<?php

$data = [
    'order_id' => '201810260011',
    'amount' => '1.00',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $public_key = file_get_contents('../includes/public.key');
    $public_key_res = openssl_pkey_get_public($public_key);
    $data_json = json_encode($data);
    openssl_public_encrypt($data_json, $encrypt, $public_key_res);
    $pay_data = urlencode(base64_encode($encrypt));

    header('Content-Type:application/json; charset=utf-8');
    echo json_encode([
        'success' => true,
        'payment_data' => $pay_data
    ]);
    exit;
}


?>
<html>
<meta charset="utf-8">

<script src="http://libs.baidu.com/jquery/2.1.1/jquery.min.js"></script>

<body>
<!--    <a href="pay.php?payment_data=--><?php //echo $pay_data;?><!--">GET 支付订单</a><br>-->
    <a href="javascript:;" onclick="toPay('<?php echo $data['order_id']?>')">POST 支付订单</a>
<script>
    function toPay(order_id) {
        $.ajax({
            'type': 'POST',
            'async': true,
            'data': 'order_id=' + order_id,
            'dataType': 'json',
            'success': function(resp) {
                if (resp.success) {
//                    window.open('pay.php?payment_data=' + resp.payment_data);
                    location.href = 'pay.php?payment_data=' + resp.payment_data;
                }
            }
        });
    }
</script>
</body>
</html>

