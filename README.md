Yii2 component for AWS
=====================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist grigorieff/yii2-aws "master-dev"
```

or add

```json
"grigorieff/yii2-aws": "*"
```

to the require section of your composer.json.

Configuration
------------

Add to your app config:

```php
    'components' => [

        .........

        'aws' => [
            'class' => grigorieff\aws\AWSComponent,
            'key' => '......',
            'secret' => '......',
            'region' => '......'
        ],

        .........

    ];
```

Usage
------------

```php
$aws = Yii::$app->aws;

// AWS S3

$s3 = $aws->get('s3');

try {
    $s3->putObject(array(
        'Bucket' => 'my-bucket',
        'Key'    => 'my-object',
        'Body'   => fopen('/path/to/file', 'r'),
        'ACL'    => 'public-read',
    ));
} catch (S3Exception $e) {
    echo "There was an error uploading the file.\n";
}

......

try {
    $resource = fopen('/path/to/file', 'r');
    $s3->upload('my-bucket', 'my-object', $resource, 'public-read');
} catch (S3Exception $e) {
    echo "There was an error uploading the file.\n";
}

......

$s3->getObject(array(
    'Bucket' => $bucket,
    'Key'    => 'data.txt',
    'SaveAs' => '/tmp/data.txt'
));
echo $result['Body']->getUri() . "\n";

```