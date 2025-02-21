<?php
require_once '../config.php';
require_once '../functions.php';

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

$paymentId = $_GET['paymentId'];
$payerId = $_GET['PayerID'];

$payment = Payment::get($paymentId, $paypal);

$execution = new PaymentExecution();
$execution->setPayerId($payerId);

try {
    $result = $payment->execute($execution, $paypal);
    // Handle payment success
    // Update database, send confirmation message, etc.
    echo "Payment Successful!";
} catch (Exception $ex) {
    echo "Error: " . $ex->getMessage();
    exit(1);
}