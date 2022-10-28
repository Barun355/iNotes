<?php
// importing the database module.
require 'utils/db.php';

$signup = false;
$showError = false;

session_start();

// checking for the POST request if it their is any.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // checking if the POST request for signin up
    if (isset($_POST['emailSignUp'])) {
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $uname = $_POST['uname'];
        $emailSignUp = $_POST['emailSignUp'];
        $passwordSignUp = $_POST['passwordSignUp'];
        $passwordHash = password_hash($passwordSignUp, PASSWORD_DEFAULT);

        $query = "SELECT * FROM `users` WHERE `uname` LIKE '$uname';";
        $result = $conn->query($query);

        // checking the user alread exist.
        if (mysqli_num_rows($result) != 0) {
            $showError = 'User Exist';
        } 

        // if user not exist then creating the user.
        else {
            $queryInsert = "INSERT INTO `users` (`fname`, `lname`, `uname`, `email`, `password`) VALUES ('$fname', '$lname', '$uname', '$emailSignUp', '$passwordHash');";
            $resultInsert = $conn->query($queryInsert);

            $queryTable = "CREATE TABLE `inotes`.`".$uname."` (`sno` INT NOT NULL AUTO_INCREMENT, `title` VARCHAR(100) NOT NULL , `description` TEXT NOT NULL , `tstamp` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`sno`))";
            $resultTable = $conn->query($queryTable);

            require 'utils/_unauthorizedNotes.php';

            if ($resultInsert and $resultTable) {
                $signup = true;

            } else {
                $showError = 'Server error';
            }
        }
        
    
    }


    // if the POST request is for sign in.
    if(isset($_POST['emailSignIn'])){
        $email = $_POST['emailSignIn'];
        $password = $_POST['passwordSignIn'];
    
        // SELECT * FROM `users` WHERE `email` LIKE 'baruntiwary@gmail.com' AND `password` LIKE '1234'
        $query = "SELECT * FROM `users` WHERE `email` LIKE '$email'";
        $result = $conn->query($query);
        
        // checking if the user account is unqiue.
        if (mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_assoc($result);
            
            // verifying the user password.
            if (password_verify($password, $data['password'])) {
                $uname = $data['uname'];
                $_SESSION['userID'] = $uname;
                $_SESSION['userName'] = $data['fname'].' '.$data['lname'];
                require 'utils/_unauthorizedNotes.php';
                header("location: /iNotes/notes.php");
            }
            else{
                $showError = "Password Invalid!";
            }
        }
        else{
            $showError = "Invalid Email!";
        }
    }
}

?>




<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes | Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    
    <!-- importing navagation bar -->
    <?php require 'utils/_nav.php';?>

    <?php
    
    // showing alert accoring the user interaction.
    if ($signup) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Sign Up successfully!</strong> Use your credential to Sign In.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong> ' . $showError . ' !</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
    }
    ?>


    <!-- showing the form for sign UP. -->
    <div class="container mt-5" id="signUp">

        <form action="registration.php" method="POST" class="row g-3">
            <div class="row-mb-3">
                <label for="fname" class="form-label">First name</label>
                <input type="text" class="form-control" placeholder="First name" name="fname" aria-label="First name">
            </div>
            <div class="row-mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" placeholder="Last name" name="lname" aria-label="Last name">
            </div>
            <div class="row-mb-3">
                <label for="uname" class="form-label">User Name</label>
                <input type="text" class="form-control" id="uname" placeholder="User Name" name="uname" aria-label="Last Name">
            </div>
            <div class="row-mb-3">
                <label for="inputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail1" name="emailSignUp" placeholder="example@gmail.com" required>
            </div>
            <div class="row-mb-3">
                <label for="inputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword1" name="passwordSignUp" placeholder="XXXXXX">
            </div>
            <div class="row-mb-3">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
        </form>
    </div>

    <!-- showing the form for sign IN. -->
    <div class="container" id="signIn" style="margin-top: 10rem;">
        <form action="registration.php" method="POST">
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail3" name="emailSignIn" >
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" name="passwordSignIn" >
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>


    <!-- main js script for handling event. -->
    <script>
        signUp = document.getElementById('signUp');
        signIn = document.getElementById('signIn');

        signUp.style = 'display: none';

        document.getElementById('signUpButton').addEventListener('click', (e) => {
            signUp.style = 'display: block';
            signIn.style = 'display: none';
            document.title = 'SignUp | page';
            console.log('signUp');
        });
        
        document.getElementById('signInButton').addEventListener('click', (e) => {
            signUp.style = 'display: none';
            signIn.style = 'display: block; margin-top: 10rem';
            document.title = 'SignIn | page';
            console.log('signIn');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>