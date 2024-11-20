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
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="./style.css" rel="stylesheet">
</head>
<body>
        <div class="container">

        <?php 
            if(isset($_POST["submit"])){
               $fullName = $_POST["fullname"];
               $email = $_POST["email"];
               $password = $_POST["password"];
               $repeatPassword = $_POST["repeat_password"];
               $errors = array();

               require_once "salt.php";

               if(empty($fullName) OR empty($email) OR empty($password) OR empty($repeatPassword)){
                array_push($errors, "All Fields are required");
               }

               if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errors, "Enter valid Email");
               }

               if(strlen($password) < 8){
                array_push($errors, "Password must be at least 8 characters long");
               }

               if($password !== $repeatPassword){
                array_push($errors, "Password does not match");
               }

               require_once "database.php";
               $sql = "Select * from users where email = '$email' ";

       

               $arrayResult = mysqli_fetch_assoc(mysqli_query($conn, $sql));

               if(!empty($arrayResult)){
                array_push($errors, "Email already exists.");
               }

               var_dump($arrayResult);

               if(!empty($errors)){
                foreach($errors as $error){
                    echo "<div class='alert alert-danger' >
                        $error
                    </div>";
                }
                }

                else {

                    $combinedPassword = $password.$salt;
                    $hashedPassword = password_hash($combinedPassword, PASSWORD_BCRYPT);
                    
                    $sql = "Insert into users (fullname, password, email) values (?, ?, ?)";

                    $stmt = mysqli_stmt_init($conn); 
                
                    $preparedStmt = mysqli_stmt_prepare($stmt, $sql);

                    if($preparedStmt){
                        
                        mysqli_stmt_bind_param($stmt, "sss", $fullName, $hashedPassword, $email);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>
                            You are registered successfully. <a class='link' href='./login.php'>Login</a>
                        </div>";

                        die();
                    }else{
                        die("Something went wrong");
                    }
                }
               }
        ?>
            <form action="registration.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name ="fullname" placeholder="Full Name:"> 
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name ="email" placeholder="Email:"> 
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name ="password" placeholder="Password:"> 
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name ="repeat_password" placeholder="Repeat Password:"> 
                </div>
                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" value="Register" name="submit">
                </div>
            </form>
            <div>
                <p>If already registered. <a href="./login.php">Login here.</a></p>
            </div>
        </div>
</body>
</html>