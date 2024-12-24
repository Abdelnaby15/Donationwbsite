<?php
require 'db.php'; // Ensure this connects to your database

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $name = htmlspecialchars($data['name']);
    $email = htmlspecialchars($data['email']);
    $cause = htmlspecialchars($data['cause']);
    $amount = floatval($data['amount']);

    try {
        $stmt = $pdo->prepare("INSERT INTO donations (name, email, cause, amount) VALUES (:name, :email, :cause, :amount)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'cause' => $cause,
            'amount' => $amount,
        ]);

        echo json_encode(['message' => 'Donation successful. Thank you!']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Error saving donation', 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Invalid request method']);
}
