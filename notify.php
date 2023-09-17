<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

$available = $_GET["available"];

$servername = "localhost";
$username = "root";
$password = "";
$database = "iot";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$ac = $conn->query("SELECT consumed FROM ac WHERE `date` = CURDATE()")->fetch_object()->consumed;
$cam = $conn->query("SELECT consumed FROM cam WHERE `date` = CURDATE()")->fetch_object()->consumed;
$fan = $conn->query("SELECT consumed FROM fan WHERE `date` = CURDATE()")->fetch_object()->consumed;
$light = $conn->query("SELECT consumed FROM light WHERE `date` = CURDATE()")->fetch_object()->consumed;
$motion = $conn->query("SELECT consumed FROM motion WHERE `date` = CURDATE()")->fetch_object()->consumed;

$mail = new PHPMailer(true);

//Enable SMTP debugging.
//$mail->SMTPDebug = 3;                               
//Set PHPMailer to use SMTP.
$mail->isSMTP();            
//Set SMTP host name                          
$mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;                          
//Provide username and password     
$mail->Username = "fydp12@gmail.com";                 
$mail->Password = "evnalfcgmxhqewwz";                           
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";                           
//Set TCP port to connect to
$mail->Port = 587;                                   

$mail->From = "fydp12@gmail.com";
$mail->FromName = "FYDP UIU";

$mail->addAddress("protikkanu111@gmail.comm");

$mail->isHTML(true);

$mail->Subject = "IOT Power Consumption";
$mail->Body = "<i>Alert! Power Consumed: ".$available.". Take necessary action.</i><br>";
$mail->Body .= "AC consumed: ".$ac." Watts<br>";
$mail->Body .= "Cam consumed: ".$cam." Watts<br>";
$mail->Body .= "Fan consumed: ".$fan." Watts<br>";
$mail->Body .= "Light consumed: ".$light." Watts<br>";
$mail->Body .= "Motion Detector consumed: ".$motion." Watts<br>";
//$mail->AltBody = "Alert! Power Consumed: ".$available.". Take necessary action.";

try {
    $mail->send();
    //echo "Message has been sent successfully";
} catch (Exception $e) {
    //echo "Mailer Error: " . $mail->ErrorInfo;
}