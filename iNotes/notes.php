<?php

  session_start();

  $unauthorizedSignIn = false;
  $insert = false;
  $update = false;
  $delete = false;

  // validating if access to this page is valid or not
  if(isset($_SESSION['userID'])){

    // importing the database module to connect to database
    require 'utils/db.php';
    
    // if the valid user is accessing this page then initilizating the table name and the user name of the user from the session.
    $table = $_SESSION['userID'];
    $name = $_SESSION['userName'];

    // checking if their is any POST request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      // if the post request is set to update.
      if (isset($_POST['snoEdit'])) {
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $descreption = $_POST['descriptionEdit'];

        // UPDATE `".$table."` SET `title` = 'Stusadf', `description` = 'I have to till 2am.' WHERE `".$table."`.`sno` = 6;
        $query = "UPDATE `".$table."` SET `title` = '$title', `description` = '$descreption', `tstamp` = 'current_timestamp()' WHERE `".$table."`.`sno` = $sno";
        $result = $conn->query($query);
        $update = true;
      }

      // if the POST is set to delete the note.
      if(isset($_POST['snoDelete'])) {
        $sno = $_POST['snoDelete'];

        // DELETE FROM `".$table."` WHERE `".$table."`.`sno` = 1
        $query = "DELETE FROM `".$table."` WHERE `".$table."`.`sno` = $sno";
        $result = $conn->query($query);
        $delete = true;
      }

      // if the POST request is set to insert the new note.
      else {
        $title = $_POST['title'];
        $descreption = $_POST['description'];

        // INSERT INTO `".$table."` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Barun', 'Hello how are you', current_timestamp());
        $query = "INSERT INTO `".$table."` (`title`, `description`, `tstamp`) VALUES ('$title', '$descreption', current_timestamp())";
        $result = $conn->query($query);
        $insert = true;
      }
    }
  }
  
  else{
    // if the invalid user is trying to access the noteboook the setting the unauthorized variable to true.
    // and waiting for the user response if they want to proceed without login or registering then taking the note detail from the form
    // and storing that information to the session cookie, after that redirecting the user to registration page.
    $unauthorizedSignIn = true;
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(isset($_POST['title'])){
        session_start();
        $_SESSION['title'] = $_POST['title'];
        $_SESSION['description'] = $_POST['description'];
        header("location: /iNotes/registration.php");
      }
    }
  }

?>

<!-- main body of the web page. -->
<!doctype html>
<html lang="en">

<!-- setting the head of the web page. -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iNotes | Take ur notes.</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<!-- main body of the web page starts here. -->
<body>

  <!-- Delete Modal -->
  <!-- This modal is for prompting the user the form for deleting the note. -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Delete the Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="notes.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <input type="hidden" id="snoDelete" name="snoDelete">
              <label for="titleDelete" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleDelete" name="titleDelete" aria-describedby="titleHelp" readonly>
            </div>
            <div class="mb-3">
              <label for="descriptionDelete" class="form-label">Description</label>
              <textarea type="description" class="form-control" id="descriptionDelete" name="descriptionDelete" readonly></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Update Modal -->
  <!-- This modal is for prompting the user the form for updating the note. -->
  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update the Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="notes.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <input type="hidden" id="snoEdit" name="snoEdit">
              <label for="titleEdit" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="titleHelp" required>
            </div>
            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Description</label>
              <textarea type="description" class="form-control" id="descriptionEdit" name="descriptionEdit" required></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>


  <!-- importing the database module. -->
  <?php require 'utils/_nav.php';?>
  
  <?php
  // for showing the successful insetion alert.
  if ($insert == true) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Inserted</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    $insert = false;
  }
  
  // for showing the successful updation alert.

  if ($update == true) {
    echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Updated</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    $update = false;
  }
  
  // for showing the successful deletion alert.
  if ($delete == true) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Delete</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    $delete = false;
  }

  ?>

  <!-- To display the welcome page -->
  <div class="container mt-2">
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Welcome to iNotes</h4>
      <p>Explore your notes 
        <?php 
          if (!$unauthorizedSignIn){
            echo $name.'.';
          }
          else
            echo ' BUT LOGIN/REGISTER FIRST.';
        ?>
      </p>
    </div>
  </div>

  <!-- showing the form to create notes to the user. -->
  <div class="container mt-4">
    <form action="notes.php" method="POST">
      <div class="mb-3">
        <label for="validationDefault01" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="validationDefault01" name="title" aria-describedby="title" placeholder="Note title" required>
      </div>
      <div class="mb-3">
        <label for="validationDefault02" class="form-label">Body</label>
        <textarea type="textArea" class="form-control" id="validationDefault02" name="description" placeholder="Body" style="height:100px;" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      <?php echo '<buttton type="button" class="btn btn-primary" id="signInButton" style="margin-right: 10px;" onclick="window.location = \'/iNotes/registration.php\';">Sign In</buttton>'; ?>
    </form>
  </div>

  <!-- This section for displaying the notes in tabular formate -->
  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sno</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(!$unauthorizedSignIn){
          // SELECT * FROM `".$table."`
          $query = "SELECT * FROM `".$table."`";
          $result = $conn->query($query);
          $sno = 0;
          while ($data = mysqli_fetch_assoc($result)) {
            $sno += 1;
            $title = $data['title'];
            $description = $data['description'];
            echo "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $title . "</td>
                        <td>" . $description . "</td>
                        <td> <button class='edit btn btn-sm btn-primary' id=" . $data['sno'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $data['sno'] . ">Delete</button>  </td>
                      </tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- main JavaScript to handle events. -->
  <script>
    edit = document.getElementsByClassName('edit');
    Array.from(edit).forEach((element) => {
      element.addEventListener("click", (e) => {

        // console.log('edit');

        $('#updateModal').modal('toggle');

        tr = e.target.parentNode.parentNode;

        sno = element.id;
        title = tr.getElementsByTagName('td')[0].innerHTML;
        description = tr.getElementsByTagName('td')[1].innerHTML;

        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = sno;

        // console.log(tr);

      });
    });



    del = document.getElementsByClassName('delete');
    Array.from(del).forEach((element) => {
      element.addEventListener("click", (e) => {
        // console.log('delete');
        $('#deleteModal').modal('toggle');

        tr = e.target.parentNode.parentNode;

        sno = element.id.substr(1);
        title = tr.getElementsByTagName('td')[0].innerHTML;
        description = tr.getElementsByTagName('td')[1].innerHTML;

        snoDelete.value = sno;
        titleDelete.value = title;
        descriptionDelete.value = description;

        console.log(sno);
        console.log(description);
        console.log(title);


      });
    });

    document.getElementById('logOut').addEventListener("click", (e)=>{
      window.location = 'logout.php';
    });

    button = document.getElementById('submit');
    console.log(button);
  </script>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

  <!-- js template from datatables to formate the tables. -->
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();

    });
  </script>
</body>

</html>