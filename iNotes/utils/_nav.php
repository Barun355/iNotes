<?php
    $userID = false;

    if(isset($_SESSION['userID'])){
        $userID = true;
    }
    
    // navbar component.
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">iNotes</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/iNotes/index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="notes.php">Notes</a>
                        </li>
                    </ul>'; if($userID){
                        echo '
                        <buttton type="button" class="btn btn-outline-danger" id="logOut">Log Out</buttton>';
                    }
                    else{
                        if(!isset($unauthorizedSignIn)){

                            echo '
                        <buttton type="button" class="btn btn-outline-primary" id="signInButton" style="margin-right: 10px;">Sign In</buttton>
                        <buttton type="button" class="btn btn-outline-primary" id="signUpButton" style="margin-right: 10px;">Sign Up</buttton>';
                        }
                    }
                    echo '
                </div>
            </div>
        </nav>';