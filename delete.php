<?php
include('connect.php');

if(isset($_POST['id'])){
    $id = (int) $_POST['id'];
    mysqli_query($conn, "DELETE FROM tasks WHERE id = $id");
    echo "success";
}
