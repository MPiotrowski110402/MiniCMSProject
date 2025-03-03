<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';
global $conn;
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
        $client_id = isset($_POST['client_id']) ? (int)$_POST['client_id'] :0;
        header("Location: index.php?page=report_add&client_id=" . $client_id);
        exit();
    }
}
if(isset($_POST['report_add_btn'])) {
    $user_id = isset($_SESSION['id']) ? (int)$_SESSION['id'] :0; 
    $client_id = isset($_GET['client_id']) ?(int)$_GET['client_id']:0;
    $task_id = isset($_POST['task_id']) ? (int)$_POST['task_id'] :0;
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    if($task_id > 0){
        if(!empty($title) &&!empty($description)) {
            $sql = "INSERT INTO reports
             (user_id, clients_id, tasks_id, title, content)
              VALUES (?,?, ?, ?, ?)";
              echo "insert";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiiss", $user_id, $client_id, $task_id, $title, $description);
            if($stmt->execute()){;
                $update = "UPDATE tasks SET reported = 1 WHERE id = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("i", $task_id);
                $stmt->execute();
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
    $sql = "SELECT * FROM tasks WHERE client_id = ? AND reported = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
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