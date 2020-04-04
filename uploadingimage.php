<?php


error_reporting(0);

require_once(__DIR__ . '/vendor/autoload.php');

use Aws\S3\S3Client;
use Aws\Rekognition\RekognitionClient;


$bucket = 'Your Bucket Name';
$keyname = 'Your File Name';

$s3 = S3Client::factory([
'profile' => 'default',
'region' => 'us-east-2',
'version' => '2006-03-01',
'signature' => 'v4'
]);

try {
    // Upload data.
$result = $s3->putObject([
'Bucket' => $bucket,
'Key'     => $keyname,
'SourceFile'   => __DIR__. "/$keyname",
'ACL'     => 'public-read'
]);

    // Print the URL to the object.
$imageUrl = $result['ObjectURL'];
if($imageUrl) {
echo "Image upload done... Here is the URL: " . $imageUrl;
}
} catch (Exception $e) {
echo $e->getMessage() . PHP_EOL;
}
