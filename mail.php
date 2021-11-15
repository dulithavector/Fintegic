<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

//require vendors
require 'vendor/autoload.php';

//assign vendors

//php mailler settings
$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
$phpmailer->Host = 'smtp.mailtrap.io';
$phpmailer->SMTPAuth = true;
$phpmailer->Port = 2525;
$phpmailer->Username = 'b8d631d94f50f2';
$phpmailer->Password = 'af858d2107da68';
$phpmailer->isHTML(true);
$phpmailer->setFrom('info@fintegic.lk', 'Fintegic');
$phpmailer->addAddress('info@fintegic.lk', 'Fintegic');     // Add a recipient

// Check for empty fields
// echo json_encode($_POST); exit();
if(empty($_POST['name'])||empty($_POST['email'])||empty($_POST['message'])||!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
    echo json_encode([
        'message' => 'No arguments Provided!',
        'success' => false
    ]);
    return false;
}

//assign data to varibles
$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$message = strip_tags(htmlspecialchars($_POST['message']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$data = array('name' => $name, 'email' => $email , 'message' => $message ,'phone' => $phone);
// $showCapcha = (isset($_SESSION['attempt']) && $_SESSION['attempt'] >= 3) ? true : false;

$phpmailer->Subject = 'Contact form on Fintegic';
$phpmailer->Body    = 'Name : '.$name. '<br> Email : '.$email. '<br><br> Message : '. $message;
$options = array(
    'http' => array(
        'method' => 'POST',
        'content' => http_build_query($data))
);
$stream = stream_context_create($options);
//$phpmailer->msgHTML(file_get_contents('email_html.php',false,$stream), __DIR__);
if(!$phpmailer->send()) {
    echo json_encode([
        'message' => 'Message could not be sent.',
        'success' => false,
        'error' => $phpmailer->ErrorInfo
    ]);
    return false;
} else {

//    echo json_encode([
//        'message' => 'Message Sent',
//        'success' => true,
//    ]);
//    return true;
    header('Location: index.html');

}

?>
