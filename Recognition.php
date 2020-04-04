<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Aws\S3\S3Client;
use Aws\Rekognition\RekognitionClient;


$bucket = 'aws-webinar-ethnus';
$keyname = 's.jpg';

$s3 = new S3Client([
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
'ACL'     => 'public-read-write'
]);

    // Print the URL to the object.
$imageUrl = $result['ObjectURL'];
if($imageUrl) {
echo "Image upload done... Here is the URL: " . $imageUrl;

$rekognition = new RekognitionClient([
'region' => 'us-east-2',
'version' => 'latest',
]);

$result = $rekognition->detectFaces([
'Attributes' => ['DEFAULT'],
'Image' => [
'S3Object' => [
'Bucket' => $bucket,
'Name' => $keyname,
'Key' => $keyname,
],
],
]);

echo "Totally there are " . count($result["FaceDetails"]) . " faces";
}
} catch (Exception $e) {
echo $e->getMessage() . PHP_EOL;
}
