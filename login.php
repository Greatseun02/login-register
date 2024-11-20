<?php 
    session_start();
    if(isset($_SESSION["user"])){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="./style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php 
            if(isset($_POST["login"])){
                $email = $_POST["email"];
                $password = $_POST["password"];

                require_once "salt.php";
                $combinedPassword = $password.$salt;
                $errors = [];


                require_once "database.php";

                $sql = "SELECT * from users where email = '$email'";
                
                $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                if(empty($result)){
                    array_push($errors, "Email does not exist.");
                }
                elseif(!password_verify($combinedPassword, $result["password"])){
                    array_push($errors ,"Password does not match.");
                }

                if(!empty($errors)){
                    foreach($errors as $error){
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }else{
                    session_start();
                    $_SESSION["user"] = "yes";

                    header("Location: index.php");
                    die();
                }

            }
        ?>
        <form action="login.php" method="Post">
            <div class="form-group">
                <input name="email" placeholder="Enter Email:" type="email" class="form-control" />
            </div>
            <div class="form-group">
                <input name="password" placeholder="Enter Password:" type="password" class="form-control" />
            </div>
            <div class="form-btn">
            <input name="login" value="Login" type="submit" class="btn btn-primary" />
            </div>
        </form>
        <div>
                <p>If not registered. <a href="./registration.php">Register here.</a></p>
        </div>
    </div>
</body>
</html>