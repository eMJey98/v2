<?php
require_once '../config.php';
require_once '../functions.php';

use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

$payer = new Payer();
$payer->setPaymentMethod('paypal');

$amount = new Amount();
$amount->setTotal('10.00');
$amount->setCurrency('USD');

$transaction = new Transaction();
$transaction->setAmount($amount);
$transaction->setDescription('VPN Service Payment');

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("https://yourdomain.com/payment/paypal_success.php")
    ->setCancelUrl("https://yourdomain.com/payment/paypal_cancel.php");

$payment = new Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions([$transaction])
    ->setRedirectUrls($redirectUrls);

try {
    $payment->create($paypal);
    header("Location: " . $payment->getApprovalLink());
    exit();
} catch (Exception $ex) {
    echo "Error: " . $ex->getMessage();
    exit(1);
}