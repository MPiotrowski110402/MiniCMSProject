<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';

function getClient(){
    global $conn;
    $sql = "SELECT * FROM clients";
    $result = $conn->query($sql);
    $tasks = [];
    while($row = $result->fetch_assoc()) {
        $tasks[] = [
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
        ];
    }
    return $tasks;
}

if (isset($_POST['report_add_btn'])) {
    if (isset($_POST['client_id'])) {
        $client_id = $_POST['client_id'];
        header("Location: index.php?page=report_add&client_id=" . $client_id);
        exit();
    }
}
if(isset($_POST['report_add_btn'])) {
    $user_id = 1;
    $client_id = $_GET['client_id'];
    $task_id = $_POST['task_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    if(!empty($task_id) || $task_id != null){
        if(!empty($title) &&!empty($description)) {
            $sql = "INSERT INTO reports (user_id, clients_id, tasks_id, title, content) VALUES ($user_id, $client_id, $task_id, '$title', '$description')";
            if ($conn->query($sql) === TRUE) {
                 mysqli_query($conn, "UPDATE tasks SET reported = 1 WHERE id = $task_id");
                header("Location: index.php?page=reports");
                exit();
            } else {
                echo "Error: ". $sql. "<br>". $conn->error;
            }
        }
    }
}



if(isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    $sql = "SELECT * FROM tasks WHERE client_id = $client_id AND reported = 0";
    $result = $conn->query($sql);
    $tasks = [];
    while($row = $result->fetch_assoc()) {
        $tasks[] = [
            'id' => $row['id'],
            'title' => $row['title'],
        ];
    }
    echo $twig->render('addReports_1.twig', [
        'tasksList' => $tasks,
    ]);
}else{



$client = getClient();
echo $twig->render('addReports.twig', [
        'clientsList' => $client,
]);
}
?>