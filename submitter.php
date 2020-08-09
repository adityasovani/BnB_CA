<?php
    
    use PHPMailer\PHPMailer\PHPMailer;

    require_once "phpmailer/PHPMailer.php";
    require_once "phpmailer/SMTP.php";
    require_once "phpmailer/Exception.php";
    require 'phpmailer/PHPMailerAutoload.php';

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        die("<center> <h1>500</h1> <b>Internal Server error</B></center>");
    }
    else {

    $name = $_POST["fname"]." ".$_POST["lname"];
    $mobile = $_POST["mobile"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $xii = $_POST["xii"];
    $cpt = $_POST["cpt"];
    $icaireg = $_POST["icaireg"];
    $grp1 = $_POST["grp1"];
    $grp2 = $_POST["grp2"];
    $dir = $_POST["dir"];
    
    $file = "uploads/".basename($_FILES['resume']['name']);
    move_uploaded_file($_FILES['resume']['tmp_name'],$file);

    $groupBody = null;

    /*if (empty($_POST['recaptcha'])) {
        exit('Please set recaptcha variable');
    }
    // validate recaptcha
    $response = $_POST['recaptcha'];
    $post = http_build_query(
         array (
             'response' => $response,
             'secret' => '6Ldw0rkUAAAAAFv2K5c0r0utoRLvVWZll2sw6TWh',
             'remoteip' => $_SERVER['REMOTE_ADDR']
         )
    );
    $opts = array('http' => 
        array (
            'method' => 'POST',
            'header' => 'application/x-www-form-urlencoded',
            'content' => $post
        )
    );
    $context = stream_context_create($opts);
    $serverResponse = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
    if (!$serverResponse) {
        exit('Failed to validate Recaptcha');
    }
    $result = json_decode($serverResponse);
    if (!$result -> success) {
        exit('Invalid Recaptcha');
    }*/

    if ($grp1 == "undefined" && $grp2 == "undefined") {
        $groupBody = "<tr>
            <td><b>Direct Entry Scheme</b></td>
            <td>YES</td>
            </tr><tr>
            <td><b>B.Com Score</b></td>
            <td>$dir</td>
            </tr>";
    }

    if($grp1 == "undefined" && $grp2 != "undefined"){
        $groupBody = "<tr>
            <td><b>Group 2 Score</b></td>
            <td>$grp2</td>
            </tr><tr>
            <td><b>Group 1 Score</b></td>
            <td>Pending</td>
            </tr>";
    }
    
    if($grp1 != "undefined" && $grp2 == "undefined"){
        $groupBody = "<tr>
            <td><b>Group 1 Score</b></td>
            <td>$grp1</td>
            </tr><tr>
            <td><b>Group 2 Score</b></td>
            <td>Pending</td>
            </tr>";
    }

    if ($grp1 != "undefined" && $grp2 != "undefined") {
        $groupBody ="<tr>
        <td><b>Group 1 Score</b></td>
        <td>$grp1</td>
        </tr>
        <tr>
        <td><b>Group 2 Score</b></td>
        <td>$grp2</td>
        </tr>
        <br>
        <p>PFA for resume.</p>
        ";
    }
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
        $mail->Subject = "New Articleship Application from $name";
        $mail->Body = "
            <h3>Application Details </h3> 
            <table border='2'>
                <tr>
                    <td><b>Name</b></td>
                    <td>$name</td>
                </tr>
                <tr>
                    <td><b>Mobile No.</b></td>
                    <td>$mobile</td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td>$email</td>
                </tr>
                <tr>
                    <td><b>Address</b></td>
                    <td>$address</td>
                </tr>
                <tr>
                    <td><b>12th Score</b></td>
                    <td>$xii</td>
                </tr>
                <tr>
                    <td><b>CA Foundation / CPT Score</b></td>
                    <td>$cpt</td>
                </tr>
                <tr>
                    <td><b>ICAI Registration No.</b></td>
                    <td>$icaireg</td>
                </tr>
                $groupBody
            </table>
        ";
        $mail->addAttachment($file);

        if ($mail->send()) {
            exit("Acknowledge");
            unlink($_FILES['resume']['tmp_name']);
        } else {
            exit($mail->ErrorInfo);
            unlink($_FILES['resume']['tmp_name']);
        }
    }
?>
