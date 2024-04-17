<?php

require_once '/home/vds/www/vendor/autoload.php';
require_once '/usr/share/php/stuff.php';

$name = filter_var($_REQUEST['invitee_full_name'], FILTER_SANITIZE_STRING);
$notes = filter_var($_REQUEST['answer_1'], FILTER_SANITIZE_STRING);
$email = ''; # = filter_var($_REQUEST['invitee_email'], FILTER_SANITIZE_EMAIL);
$phone = ''; # = filter_var($_REQUEST['invitee_email'], FILTER_SANITIZE_STRING);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email format');
}

$client = new \GuzzleHttp\Client();
$response = $client->post("https://system.easypractice.net/api/v1/clients", [
    'headers' => [
        "Content-Type" => "application/json",
        "Accept" => "application/json",
        "Authorization" => "Bearer " . getenv('EASYCRUIT_API')
    ],
        'json' => [
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "notes" => $notes
                ]
    ]);

if ($response->getStatusCode() != 200) {
    die('API request failed with status ' . $response->getStatusCode());
}

$body = $response->getBody();
print_r(json_decode((string) $body));

?>
