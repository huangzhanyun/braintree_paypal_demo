<?php
require_once("../includes/braintree_init.php");

$nonce = $_POST["payment_method_nonce"];
$payment_data_raw = $_POST['payment_data'];

$payment_data_json = private_decrypt($payment_data_raw);

if (!$payment_data_json) {
    errorPage('支付参数无效');
}
$payment = json_decode($payment_data_json, true);


$result = $gateway->transaction()->sale([
    'amount' => $payment['amount'],
    'paymentMethodNonce' => $nonce,
    'options' => [
        'submitForSettlement' => true
    ]
]);

if ($result->success || !is_null($result->transaction)) {
    $transaction = $result->transaction;

    $transactionSuccessStatuses = [
        Braintree\Transaction::AUTHORIZED,
        Braintree\Transaction::AUTHORIZING,
        Braintree\Transaction::SETTLED,
        Braintree\Transaction::SETTLING,
        Braintree\Transaction::SETTLEMENT_CONFIRMED,
        Braintree\Transaction::SETTLEMENT_PENDING,
        Braintree\Transaction::SUBMITTED_FOR_SETTLEMENT
    ];

    //支付成功
    if (in_array($transaction->status, $transactionSuccessStatuses)) {

        $transaction_data = [
            'order_id'   => $payment['order_id'],
            'payment_status' => 'success',
            'transaction' => [
                'id'         => $transaction->id,
                'status'     => $transaction->status,
                'amount'     => $transaction->amount,
                'created_at' => $transaction->createdAt->format('Y-m-d H:i:s'),
                'update_at'  => $transaction->updatedAt->format('Y-m-d H:i:s'),
            ],
        ];

        $transaction_json = json_encode($transaction_data);
        $callback_data = [
            'url'    => $config['callback_url']['success'],
            'status' => 'success',
            'data' => private_encrypt($transaction_json),
        ];

    }
    // 支付失败
    else {
        $transaction_data = [
            'order_id'   => $payment['order_id'],
            'payment_status' => 'fail',
            'transaction' => [
                'id'         => $transaction->id,
                'status'     => $transaction->status,
            ],
        ];

        $transaction_json = json_encode($transaction_data);
        $callback_data = [
            'url'    => $config['callback_url']['success'],
            'status' => 'fail',
            'data' => private_encrypt($transaction_json),
        ];
    }

}
// 支付失败
else {
    $errorString = "";

    foreach($result->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }

    $transaction_data = [
        'order_id'   => $payment['order_id'],
        'payment_status' => 'fail',
        'msg' => $errorString,
    ];

    $transaction_json = json_encode($transaction_data);
    $callback_data = [
        'url'    => $config['callback_url']['fail'],
        'status' => 'fail',
        'data' => private_encrypt($transaction_json),
    ];
}

$smarty->assign('callback', $callback_data);
$smarty->display('callback.html');