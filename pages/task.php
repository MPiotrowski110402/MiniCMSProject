<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';
if(isset($_GET['delete_task']) && $_GET['delete_task'] == 'true' ){
    $id = isset($_GET['id']) ? (int)$_GET['id'] :0;
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: index.php?page=tasks');
    exit();
}
function getTask(){
    global $conn;
    $task_id = isset($_GET['id']) ? (int)$_GET['id'] :0;
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
    $client_id = $task['client_id'];
    $sql = "SELECT * FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
    $tasks = [
        'id' => $task['id'],
        'first_name' => $client['first_name'],
        'last_name' => $client['last_name'],
        'contact' => $client['contact_email'],
        'phone' => $client['contact_phone'],
        'title' => $task['title'],
        'description' => $task['description'],
        'due_date' => $task['due_date'],
        'status' => $task['status'],
        'created_at' => $task['created_at'],
        'client_id' => $task['client_id'],
    ];
    return $tasks;
}
$getTask = getTask();

echo $twig->render('tasks_adv.twig', [
    'task' => $getTask,
]);
?>