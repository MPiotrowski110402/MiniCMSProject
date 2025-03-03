<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';



function getReport(){
    global $conn;
    $report_id = $_GET['report_id'];
    $sql = "SELECT * FROM reports WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $report_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = [];
    $row = $result->fetch_assoc();
        $report = [
            'id' => $row['id'],
            'clients_id' => $row['clients_id'],
            'tasks_id' => $row['tasks_id'],
            'title' => $row['title'],
            'content' => $row['content'],
            'created_at' => $row['created_at'],
        ];
    
    return $report;
}
function getClient(){
    global $conn;
    $reportInfo = getReport();
    $client_id = $reportInfo['clients_id'];
    $sql = "SELECT * FROM clients WHERE id = $client_id";
    $result = $conn->query($sql);
    $client = [];
    $row = $result->fetch_assoc();
        $client = [
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'contact' => $row['contact_email'],
            'phone' => $row['contact_phone'],
        ];
    
    return $client;
}
function getTasks(){
    global $conn;
    $reportInfo = getReport();
    $task_id = $reportInfo['tasks_id'];
    $sql = "SELECT * FROM tasks WHERE id = $task_id";
    $result = $conn->query($sql);
    $task = [];
    $row = $result->fetch_assoc();
        $task = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['status'],
            'due_date' => $row['due_date'],
        ];
    
    return $task;
}
function getNote(){
    global $conn;
    $reportInfo = getReport();
    $sql = "SELECT * FROM notes WHERE report_id = $reportInfo[id] ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $notes = [];
    while($row = $result->fetch_assoc()) {
        $notes[] = [
            'id' => $row['id'],
            'report_id' => $row['report_id'],
            'content' => $row['content'],
            'created_at' => $row['created_at'],
        ];
    }
    
    return $notes;
}
if(isset($_POST['add_note_btn'])){
    global $conn;
    $report_id = isset($_GET['report_id']) ? (int)$_GET['report_id'] :0;
    $user_id = isset($_SESSION['id']) ? (int)$_SESSION['id'] :0;
    $content = htmlspecialchars($_POST['note']);
    $sql = "INSERT INTO notes (report_id, user_id,content) 
    VALUES (?,?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $report_id, $user_id, $content);
    $stmt->execute();
    header("Location: index.php?page=report_view&report_id=$report_id");
    exit();
}



$notesInfo = getNote();
$clientInfo = getClient();
$reportInfo = getReport();
$taskInfo = getTasks();
echo $twig->render('reportView.twig', [
        'report' => $reportInfo,
        'client' => $clientInfo,
        'task' => $taskInfo,
        'notes' => $notesInfo
]);