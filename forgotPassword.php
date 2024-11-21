<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="./style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <?php 
            if(isset($_POST["submit"])){
                $email = $_POST["email"];

                require_once "database.php";

                $sql = "SELECT * FROM users WHERE email = '$email'";

                $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                if(isset($result)){
                    $otp = random_int(100000, 999999);
                    session_start();
                    $_SESSION["otp"] = strval($otp);
                  
                    $subject = "verify account otp";
                    $message = strval($otp);
                    
                    require_once "mail.php";
                    $mail->addAddress($email);

                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    if($mail->send()){
                        header("Location: verifyPassword.php");
                    }else{
                        "<div class='alert alert-danger'>Could not send mail.</div>". $mail->ErrorInfo;
                    }

                }else{
                    echo "<div class='alert alert-danger'>User does not exist.</div>";
                }
            }
        ?>
        <form action="forgotPassword.php" method="POST">
            <div class="form-group">
                <input name="email" type="email" placeholder="Enter Email" class="form-control"/>
            </div>
            <div class="form-btn">
                <input name="submit" type="submit" class="btn btn-primary"/>
            </div>
        </form>
    </div>
</body>
</html>