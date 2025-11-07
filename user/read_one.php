<?php
include "../database.php";

header('Content-Type: application/json');

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode([
        "message" => "ID tidak ditemukan!"
    ], JSON_PRETTY_PRINT);
    exit;
}

// Ambil data user berdasarkan ID
$stmt = $conn->prepare("SELECT id, username, email FROM User WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo json_encode([
        "message" => "Data user berhasil diambil",
        "data" => $user
    ], JSON_PRETTY_PRINT);
} else {
    echo json_encode([
        "message" => "User dengan ID $id tidak ditemukan"
    ], JSON_PRETTY_PRINT);
}

$stmt->close();
$conn->close();
?>
