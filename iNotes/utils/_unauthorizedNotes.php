<?php


// creating the note for unauthorized user after authorization.
if(isset($_SESSION['title'])){
    $title = $_SESSION['title'];
    $descreption = $_SESSION['description'];

    // INSERT INTO `".$table."` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Barun', 'Hello how are you', current_timestamp());
    $query = "INSERT INTO `".$uname."` (`title`, `description`, `tstamp`) VALUES ('$title', '$descreption', current_timestamp())";
    $result = $conn->query($query);
    
    unset($_SESSION['title']);
    unset($_SESSION['description']);
}

?>