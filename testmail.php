<?php

$to = 'joshuacarpenter3@gmail.com';
$subject = 'Marriage Proposal';
$message = 'Hi Jane, will you marry me?';
$from = 'donotreply@dittodrive.us';

// Sending email
if(mail($to, $subject, $message)){
    echo 'Your mail has been sent successfully.';
} else{
    echo 'Unable to send email. Please try again.';
}