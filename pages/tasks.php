<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';



if(isset($_GET['delete']) && $_GET['delete'] == 'true' ){
    $id = isset($_GET['id']) ? (int)$_GET['id'] :0;
    $sql = "UPDATE tasks SET deleted = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: index.php?page=tasks');
    exit();
}
if(isset($_GET['zakoncz']) && $_GET['zakoncz'] == 'true' ){
    $id = isset($_GET['id']) ? (int)$_GET['id'] :0;
    $sql = "UPDATE tasks SET status = 'completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: index.php?page=tasks');
    exit();
}
if(isset($_GET['active']) && $_GET['active'] == 'true' ){
    $id = isset($_GET['id']) ? (int)$_GET['id'] :0;
    $sql = "UPDATE tasks SET status = 'in_progress' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: index.php?page=tasks');
    exit();
}
function activeTasks(){
    global $conn;
    $sql = "SELECT * FROM tasks WHERE status = 'in_progress'";
    $result = $conn->query($sql);
    $tasks = [];
    while($row = $result->fetch_assoc()) {
        $tasks[] = [
            'id' => $row['id'],
            'client_id' => $row['client_id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['status'],
            'due_date' => $row['due_date']
        ];
    }
    return $tasks;
}
function pendingTasks(){
        global $conn;
        $sql = "SELECT * FROM tasks WHERE status = 'pending'";
        $result = $conn->query($sql);
        $tasks = [];
        while($row = $result->fetch_assoc()) {
            $tasks[] = [
                'id' => $row['id'],
                'client_id' => $row['client_id'],
                'title' => $row['title'],
                'description' => $row['description'],
                'status' => $row['status'],
                'due_date' => $row['due_date']
            ];
        }
        return $tasks;
}
function completedTasks(){
    global $conn;
    $sql = "SELECT * FROM tasks WHERE status = 'completed' AND deleted = 0";
    $result = $conn->query($sql);
    $tasks = [];
    while($row = $result->fetch_assoc()) {
        $tasks[] = [
            'id' => $row['id'],
            'client_id' => $row['client_id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['status'],
            'due_date' => $row['due_date']
        ];
    }
    return $tasks;
}

$activeTasks = activeTasks();
$pendingTasks = pendingTasks();
$completedTasks = completedTasks();

echo $twig->render('tasks.twig', [
    'active_tasks' => $activeTasks,
    'pending_tasks' => $pendingTasks,
    'completed_tasks' => $completedTasks
]);
?>
