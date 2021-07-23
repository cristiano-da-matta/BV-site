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

function com_create_guid() {
	$guid= sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	echo $guid;
	return $guid;
}
function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' );

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp );

    $res= exif_imagetype($output_file);
    if($res &&  ($res<4)) {
    	return $output_file;
    }
    unlink($output_file);
    return false;


}

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


// if(!empty($input_data['logomProj'])) {
// 	$guidn=com_create_guid();
// 	if(base64_to_jpeg($input_data['logomProj'], "/var/www/portfolio/uploads/".$guidn.".jpg")!=false) {
// 		$input_data['email']=str_replace('*LOGOMARCAPROJAQUI*_', "http://portfolio.effy.com.br/uploads/".$guidn.".jpg", $input_data['email'] );
// 	}
// }
// if(!empty($input_data['logomInst'])) {
// 		$guid=com_create_guid();
// 	if(base64_to_jpeg($input_data['logomInst'], "/var/www/portfolio/uploads/".$guid.".jpg")!=false) {
// 		$input_data['email']=str_replace('*LOGOMARCAAQUI*_', "http://portfolio.effy.com.br/uploads/".$guid.".jpg", $input_data['email'] );
// 		// var_dump($input_data['email']);
// 	}
// }

// $input_data['email']=str_replace('*LOGOMARCAPROJAQUI*_','',$input_data['email']);

// $email = str_replace('*LOGOMARCAAQUI*_','',$input_data['email']);

$email = $input_data['email'];

$textEmail = strip_tags($email);


// $params = array(
//   'to'        => "william@effy.com.br",
//     //  'bcc'        => "contatorsa@effy.com.br",
//         'toname'    => "Contato Formulário RSA",
//             'from'      =>  "contato@effy.com.br",
//                 'fromname'  =>  "Formulário RSA",
//                     'subject'   => "Contato Simulador",
//                         'text'      => $textEmail,
//                             'html'      => $email /*.\
//  json_encode($_GET) . json_encode($_SERVER)*/,
//                                 //'x-smtpapi' => json_encode($js),
//                                   );

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
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}
// $request =  $url.'api/mail.send.json';

// Generate curl request
// $session = curl_init($request);
// // Tell PHP not to use SSLv3 (instead opting for TLS)
// curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
// curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
// // Tell curl to use HTTP POST
// curl_setopt ($session, CURLOPT_POST, true);
// // Tell curl that this is the body of the POST
// curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
// // Tell curl not to return headers, but do return the response
// curl_setopt($session, CURLOPT_HEADER, false);
// curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// // obtain response
// $response = curl_exec($session);
// curl_close($session);

// print everything out
//print_r($response);

}

?>
