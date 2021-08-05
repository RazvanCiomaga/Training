<?php

if (isset($_POST['submit'])) {
    $customerName = $_POST['name'];
    $subject = $_POST['subject'];
    $customerMail = $_POST['mail'];
    $mailContent = $_POST['message'];
    $headers = "From: ".$customerMail;
    $txt = "You have received an email from ".$customerName.".\n\n".$mailContent;
    if (filter_var($customerMail,FILTER_VALIDATE_EMAIL)) {
        mail(sellerMail, $subject, $txt, $headers);
        header("Location: cart.php?mailsent");
    } else {
        header("Location: cart.php?wrongmail");
    }
}