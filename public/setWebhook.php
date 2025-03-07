<?php

require __DIR__ . '/vendor/autoload.php';

use App\Bot\WebhookHandler;
use App\Config\Config;

$config = new Config();
$webhookUrl = $_ENV['DOMAIN'] . "/index.php";

$webhookHandler = new WebhookHandler($config);
$response = $webhookHandler->setWebhook($webhookUrl);

echo json_encode($response, JSON_PRETTY_PRINT);
