<?php
include "../database.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode(["message" => "ID tidak ditemukan, update gagal!"]);
    exit;
}

$id = $data['id'];

// Ambil data lama
$stmtSelect = $conn->prepare("SELECT * FROM User WHERE id = ?");
$stmtSelect->bind_param("i", $id);
$stmtSelect->execute();
$result = $stmtSelect->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(["message" => "User dengan ID $id tidak ditemukan!"]);
    exit;
}

$username = isset($data['username']) ? $data['username'] : $user['username'];
$email = isset($data['email']) ? $data['email'] : $user['email'];

$stmtUpdate = $conn->prepare("UPDATE User SET username = ?, email = ? WHERE id = ?");
$stmtUpdate->bind_param("ssi", $username, $email, $id);

if ($stmtUpdate->execute()) {
    $stmtSelect->execute();
    $updatedUser = $stmtSelect->get_result()->fetch_assoc();

    echo json_encode([
        "message" => "User berhasil diupdate",
        "data" => $updatedUser
    ]);
} else {
    echo json_encode(["message" => "Update gagal, terjadi kesalahan!"]);
}

$stmtSelect->close();
$stmtUpdate->close();
$conn->close();
?>
