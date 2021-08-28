<?php
$captcha = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
if(!$captcha) {
    echo 'Please check the captcha form.';
    exit(1);
}
$secretKey = "6LfA7SwcAAAAAEf29bdktKzp2XkgTiyiEJNR8mka";
$ip = $_SERVER['REMOTE_ADDR'];

$u = 'https://www.google.com/recaptcha/api/siteverify';
$data = array('secret' => $secretKey, 'response' => $captcha);

$o = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    ]
];

$c = stream_context_create($o);
$r = file_get_contents($u, false, $c);
$rK = json_decode($r, true);
header('Content-type: application/json');
if($rK["success"]) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}