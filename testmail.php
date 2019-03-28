<?php





// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("joshuacarpenter3@gmail.com","testemail",$msg);
?>