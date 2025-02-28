<?php
require_once 'public/db_connection.php';

if (isset($_GET['report_id'])) {
    $report_id = intval($_GET['report_id']);

    // Pobieranie danych raportu
    $sql = "SELECT r.id, r.title, r.content, r.created_at, 
                   c.first_name, c.last_name, c.contact_email,
                   t.title AS task_title, t.description AS task_description, t.status, t.due_date
            FROM reports r
            JOIN tasks t ON r.tasks_id = t.id
            JOIN clients c ON r.clients_id = c.id
            WHERE r.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_assoc();

    if (!$report) {
        die("Brak danych dla raportu o ID $report_id");
    }

    // Pobieranie notatek do raportu
    $notes_sql = "SELECT user_id, content, created_at FROM notes WHERE report_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($notes_sql);
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $notes_result = $stmt->get_result();
    
    // Tworzenie nazwy pliku CSV
    $filename = "Raport_" . $report['id'] . ".csv";

    // Nagłówki pliku CSV
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Otwieranie strumienia wyjścia
    $output = fopen('php://output', 'w');
    
    // Zapisywanie nagłówków do pliku
    fputcsv($output, ["Raport ID", "Tytuł", "Opis", "Data utworzenia"]);
    fputcsv($output, [$report['id'], $report['title'], $report['content'], $report['created_at']]);
    
    // Sekcja klienta
    fputcsv($output, [""]);
    fputcsv($output, ["Klient"]);
    fputcsv($output, ["Imię", "Nazwisko", "Email"]);
    fputcsv($output, [$report['first_name'], $report['last_name'], $report['contact_email']]);

    // Sekcja zadania
    fputcsv($output, [""]);
    fputcsv($output, ["Zadanie"]);
    fputcsv($output, ["Tytuł", "Opis", "Status", "Termin"]);
    fputcsv($output, [$report['task_title'], $report['task_description'], $report['status'], $report['due_date']]);

    // Sekcja notatek
    fputcsv($output, [""]);
    fputcsv($output, ["Notatki"]);
    fputcsv($output, ["Użytkownik ID", "Treść", "Data utworzenia"]);

    while ($note = $notes_result->fetch_assoc()) {
        fputcsv($output, [$note['user_id'], $note['content'], $note['created_at']]);
    }

    // Zamknięcie strumienia
    fclose($output);
    exit();
}
?>
