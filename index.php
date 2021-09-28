<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

$ds_request_body = file_get_contents('php://input');

if ($ds_request_body == false) {
    $ds_request_body = '{}';
}

$arrRequestBody = (array) json_decode($ds_request_body);

if (count($arrRequestBody) == 0 || empty($arrRequestBody['logs'])) {
    echo json_encode([
        'message' => '...'
    ]);
    die();
}

$client = new SqsClient([
    'region' => 'us-east-2',
    'version' => '2012-11-05'
]);

$arrSqsResult = [];

foreach ($arrRequestBody['logs'] as $arrLog) {
    try {
        $arrParams = [
            'MessageBody' => json_encode($arrLog),
            'QueueUrl' => 'https://sqs.us-east-2.amazonaws.com/919887822206/SQSExample'
        ];

        $client->sendMessage($arrParams);

        $arrSqsResult[] = $arrLog;
    } catch (AwsException $e) {
        // Do something
    }
}

echo json_encode($arrSqsResult);
die();
