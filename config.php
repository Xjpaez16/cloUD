<?php
   
    require_once('./vendor/autoload.php');
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
   
    $dotenv->load();

    return [
        'aws' => [
            'key' => $_ENV['AWS_KEY'],
            'secret' => $_ENV['AWS_SECRET'],
            'region' => $_ENV['AWS_REGION'],
            'bucket' => $_ENV['AWS_BUCKET'],
        ]
    ]
   

?>