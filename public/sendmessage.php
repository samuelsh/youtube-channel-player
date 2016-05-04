<?php
$sendto   = "samuel.sh79@gmail.com";
$what_problematic = nl2br($_POST['what_problematic']);
$what_time  = $_POST['what_time'];

$subject  = "דיווח על סרטון בעייתי";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html;charset=utf-8 \r\n";

$msg  = "<html><body style='font-family:Arial,sans-serif;'>";
$msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>דיווח על סרטון בעייתי</h2>\r\n";
$msg .= "<p><strong>מה בעייתי:</strong> ".$what_problematic."</p>\r\n";
$msg .= "<p><strong>באיזה דקה:</strong> ".$what_time."</p>\r\n";
$msg .= "</body></html>";


if(@mail($sendto, $subject, $msg, $headers)) {
	echo "true";
} else {
	echo "false";
}

?>