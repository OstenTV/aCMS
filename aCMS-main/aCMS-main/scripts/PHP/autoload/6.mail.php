<?php

// Prepare and sends an mail.
function SendEMail($to, $info) {
    $subject = $info['subject'];
    $message = '
        <html>
            <head>
                <title>' . $info['subject'] . '</title>
            </head>
            <body>
                ' . $info['message'] . '
            </body>
        </html>
    ';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $headers .= 'From: ' . $info['nickname'] . ' <' . $info['email'] . '>' . "\r\n";
    $headers .= 'Reply-To: ' . $info['nickname'] . ' <' . $info['email'] . '>' . "\r\n";

    if (mail($to,$subject,$message,$headers)) {
        return true;
    } else {
        return false;
    }
}

?>