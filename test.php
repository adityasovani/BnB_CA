<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require_once "phpmailer/PHPMailer.php";
    require_once "phpmailer/Exception.php";
    require 'phpmailer/PHPMailerAutoload.php';
    require_once "phpmailer/SMTP.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        $message = $_POST["message"];

        $mail = new PHPMailer();

        //Email Settings

        $mail->isHTML(true);
        $mail->isSMTP();

        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'adityasovani44111@gmail.com';
        $mail->Password = 'dcmpa-5555';

        $mail->setFrom("adityasovani44111@gmail.com", "B&B Website");
        $mail->addAddress("borkarandborkarca@yahoo.com");

        $mail->Subject = "New feedback ";
        $mail->Body = "
            <h3>You got a new feedback </h3> 
            <table border='2'>
                <tr>
                    <td>Name</td>
                    <td>$name</td>
                </tr>
                <tr>
                    <td>Mobile No.</td>
                    <td>$mobile</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>$email</td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td>$message</td>
                </tr>
            </table>
        ";

        if ($mail->send()) {
            exit("Success");
        } else {
            die("Something is wrong: <br><br> " . $mail->ErrorInfo);
        }
    }
    else {
        header("index.html");
        exit();
    }
?>