<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("connection.php");
$confirmed = false;
$already = false;
$code_err = false;
if ($_POST) {

    $email = $_POST["email"];
    $selectQuery = "SELECT*FROM userinfo WHERE email='$email'";
    $select = mysqli_query($conn, $selectQuery);
    $counter = mysqli_num_rows($select);
    $user = mysqli_fetch_assoc($select);
    if (isset($_POST["button_email"])) {
        if (!isset($_POST["email"])) {
            echo '<div class="alert alert-danger" role="alert">
               you have to enter an E-mail
                </div>';
        } elseif ($user) {
            if (!$user["confirm"]) {
                $code = rand(1000, 9999);
                $updateQuery = "UPDATE userinfo SET code='$code' WHERE email='$email'";
                $update = mysqli_query($conn, $updateQuery);
                $mailer = new mailer();
                if ($mailer->run($email, $code)) {
                    echo '<div class="alert alert-success" role="alert">
                    your code has send!
                    </div>';
                }
            } else {
                $already = true;
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">
               There is no email which you entered register 
                </div>';
        }
    }




    if (isset($_POST["button_code"])) {
        if ($user) {
            if (!isset($_POST["email"])) {
                echo '<div class="alert alert-danger" role="alert">
               you have to enter an E-mail 
                </div>';
            } elseif ($_POST["inputcode"] == $user["code"]) {
                $updateQuery = "UPDATE userinfo SET confirm=true WHERE email='$email'";
                mysqli_query($conn, $updateQuery);
                $confirmed = true;
            } elseif ($user["confirm"]) {
                $already = true;
            } else {
                $code_err = true;
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">
               No such user found
                </div>';
        }
    }
}












?>
<?php

class mailer
{



    function run($email, $code)
    {

        include("connection.php");





        $icerik = "<meta charset='UTF-8'><h2>Yeni E-mail</h2>";
        $icerik .= $code;


        $mail = new PHPMailer();
        $mail->setLanguage("tr", "phpmailer/language");
        $mail->charSet = "utf-8";
        $mail->encoding = "base64";
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "yunusemreaynas@gmail.com";
        $mail->Password = "fege gozq ulqx vsav"; //uygulama şifresi
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Subject = "Feedback";

        try {
            $mail->setFrom("yunusemreaynas@gmail.com", "CODE");
        } catch (Exception $e) {
        }

        try {
            $mail->addAddress($email);
        } catch (Exception $e) {
        }

        $mail->isHTML(true);
        $mail->Body = $icerik;

        try {
            if ($mail->send()) {
                return true;
            } else {
                echo 'your mail has not sent';
            }
        } catch (Exception $e) {
        }
    }
}


?>

















<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container">
        <div class="form-wrapper">


            <form action="verifying.php" method="POST">
                <div class="content">
                    <label for="emailadress">E-mail adress :</label>
                    <input type="text" id="emailadress" name="email">
                    <button type="submit" id="button_email" name="button_email"> Send code </button><br>
                    <label for="verifykod">Verifying code :</label>
                    <input type="text" id="verify_code" name="inputcode">
                    <button type="submit" id="button_code" name="button_code"> Verify </button>

                    <?php
                    if ($confirmed) {
                        echo "<div class='alert alert-success' role='alert'>
                                    Your E-mail has verifyied
                                </div>";
                        echo "For login <a href='index.php'>page</a>";
                    }

                    if ($already) {
                        echo '<div class="alert alert-primary" role="alert">
                         Your account has already confirmed
                        </div>
                        ';
                        echo "for <a href='index.php'>login page</a>";
                    }
                    if ($code_err) {
                        echo '<div class="alert alert-danger" role="alert">
                               Wrong code please trying again!
                                </div>';
                    }




                    ?>



                </div>









            </form>



        </div>











    </div>


















    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>