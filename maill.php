<?php

require_once('./PHPMailer/PHPMailer.php');
require_once('./PHPMailer/SMTP.php');
require_once('./PHPMailer/POP3.php');
require_once('./PHPMailer/OAuth.php');
require_once('./PHPMailer/Exception.php');

use PHPMailer\PHPMailer\PHPMailer as PHPMailer;

//require 'vendor/autoload.php';
//Dotenv::load(__DIR__);
$sendgrid_apikey = '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';
//$sendgrid = new SendGrid($sendgrid_apikey);
$url = 'https://api.sendgrid.com/';
$pass = $sendgrid_apikey;
//$template_id = '<your_template_id>';
//$js = array(
//  'sub' => array(':name' => array('Elmer')),
//    'filters' => array('templates' => array('settings' => array('enable' => 1,\
 // 'template_id' => $template_id)))
//    );

// Allow from any origin
if(isset($_SERVER["HTTP_ORIGIN"]))
{
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	}
	else
	{
	    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
	        header("Access-Control-Allow-Origin: *");
		}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
            header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
        exit(0);
	}
	//From here, handle the request as it is ok

if(isset($_POST))
{

   $input_data=json_decode(file_get_contents('php://input'),TRUE);


$email = $input_data['email'];

$textEmail = strip_tags($email);


//Create a new PHPMailer instance
$mail = new PHPMailer;
$mail->CharSet = 'utf-8';
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 1;
//Set the hostname of the mail server
//$mail->Host = 'smtp.gmail.com';
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 465;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'ssl';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "bemviversmtp@gmail.com";
//Password to use for SMTP authentication
$mail->Password = "Expressoconsultor1@";
//Set who the message is to be sent from
$mail->setFrom('bemviversmtp@gmail.com', 'Contato Site bemviver');
//Set an alternative reply-to address
$mail->addReplyTo('bemviversmtp@gmail.com', 'Contato Site bemviver');
//Set who the message is to be sent to
$mail->addAddress("williamgvfranco@gmail.com", "Contato Site Bem Viver");
$mail->addAddress("cristiano781@gmail.com", "Contato Site Bem Viver");

// $mail->addAddress('graoehortinha@gmail.com', 'Contato Site Audicare');
// $mail->addAddress('claudiane.freitas97@gmail.com', 'Contato Site Grao e Hortinha');
//Set the subject line
$mail->Subject = 'Contato Site Bem Viver';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->isHTML(true);
$mail->msgHTML($email);

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}


}

?>
