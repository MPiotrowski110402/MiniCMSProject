<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';


if(isset($_POST['edit_client'])){
    global $conn;
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $contact_phone = $_POST['contact_phone'];
    $sql = "SELECT * FROM clients WHERE id = $user_id";
    $result = mysqli_query($conn,$sql);
    if($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        if(empty($first_name)){
            $first_name = $row['first_name'];
        }
        if(empty($last_name)){
            $last_name = $row['last_name'];
        }
        if(empty($email)){
            $email = $row['contact_email'];
        }
        if(empty($contact_phone)){
            $contact_phone = $row['contact_phone'];
        }
        $sql = "UPDATE clients SET first_name = '$first_name', last_name = '$last_name', contact_email = '$email', contact_phone = '$contact_phone' WHERE id = $user_id";
        mysqli_query($conn, $sql);
    }
    header('Location: index.php?page=clients');
    exit();
}
if(isset($_GET['delete']) && $_GET['delete'] == 'true'){
    global $conn;
    $user_id = $_GET['id'];
    $sql = "DELETE FROM clients WHERE id = $user_id";
    mysqli_query($conn, $sql);
    header('Location: index.php?page=clients');
    exit();
}

echo $twig->render('editClient.twig', []);


?>