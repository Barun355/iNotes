<?php
require 'db.php';

$conn = new db();
$connection = $conn->connect();

$insert = false;
$update = false;
$delete = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['snoEdit'])) {
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $descreption = $_POST['descriptionEdit'];

    // UPDATE `notes` SET `title` = 'Stusadf', `description` = 'I have to till 2am.' WHERE `notes`.`sno` = 6;
    $query = "UPDATE `notes` SET `title` = '$title', `description` = '$descreption', `tstamp` = 'current_timestamp()' WHERE `notes`.`sno` = $sno";
    $result = $conn->query($query);
    $update = true;
  }
  if(isset($_POST['snoDelete'])) {
    $sno = $_POST['snoDelete'];

    // DELETE FROM `notes` WHERE `notes`.`sno` = 1
    $query = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
    $result = $conn->query($query);
    $delete = true;
  } else {
    $title = $_POST['title'];
    $descreption = $_POST['description'];

    // INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Barun', 'Hello how are you', current_timestamp());
    $query = "INSERT INTO `notes` (`title`, `description`, `tstamp`) VALUES ('$title', '$descreption', current_timestamp())";
    $result = $conn->query($query);
    $insert = true;
  }
}


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iNotes | Take ur notes.</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update the Note</h1>
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

  <?php
  if ($insert == true) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Inserted</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    $insert = false;
  }

  if ($update == true) {
    echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Updated</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    $update = false;
  }

  if ($delete == true) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Delete</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    $delete = false;
  }

  ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/CRUD/">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/CRUD">Home</a>
          </li>
      </div>
    </div>
  </nav>
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
    </form>
  </div>
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
        // SELECT * FROM `notes`
        $query = "SELECT * FROM `notes`";
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
        ?>
      </tbody>
    </table>
  </div>

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
  </script>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();

    });
  </script>
</body>

</html>