<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';

function clientList(){
    global $conn;
    $sql = "SELECT * FROM clients";
    $result = $conn->query($sql);
    $clients = [];
    while($row = $result->fetch_assoc()) {
        $clients[] = [
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
        ];
    }
    return $clients;
}
if(isset($_POST['edit_task_btn'])){
    $id = isset($_GET['id']) ? (int)$_GET['id'] :0;
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $client = (int)$_POST['client'];
    $sql = "SELECT * FROM tasks WHERE id= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = mysqli_fetch_assoc($result);
    if(empty($title)){
        $title = $task['title'];
    }
    if(empty($description)){
        $description = $task['description'];
    }
    if(empty($date)){
        $date = $task['due_date'];
    }
    if($client == 'no_value' || empty($client)){
        $client = $task['client_id'];
    }
    $sql = "UPDATE tasks SET client_id=?, title=?, description=?, due_date=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isssi', $client, $title, $description, $date, $id);
    $stmt->execute();
    header("Location: index.php?page=task&id=$id");
    exit();
}
$clients = clientList();
echo $twig->render('editTask.twig', [
    'clientsList' => $clients,
]);
?>