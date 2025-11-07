<?php
include "../database.php"; // pastikan path benar

header('Content-Type: application/json');

// Ambil data dari request
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data lengkap
if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        "message" => "Data tidak lengkap, penambahan gagal!"
    ], JSON_PRETTY_PRINT);
    exit;
}

$username = $data['username'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT); // hash password

// Insert data ke database
$stmt = $conn->prepare("INSERT INTO User (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);

if ($stmt->execute()) {
    $id = $stmt->insert_id;
    $stmt->close();

    // Ambil data terbaru user yang baru ditambahkan
    $result = $conn->query("SELECT id, username, email FROM User WHERE id = $id");
    $newUser = $result->fetch_assoc();

    echo json_encode([
        "message" => "User berhasil ditambahkan",
        "data" => $newUser
    ], JSON_PRETTY_PRINT); // JSON bersusun ke bawah
} else {
    echo json_encode([
        "message" => "Penambahan gagal, terjadi kesalahan!"
    ], JSON_PRETTY_PRINT);
}

$conn->close();
?>
