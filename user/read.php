<?php
include "../database.php";

header('Content-Type: application/json');

$sql = "SELECT id, username, email FROM User"; // pastikan nama tabel sesuai
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode([
    "message" => "Semua user berhasil diambil",
    "data" => $users
]);

$conn->close();
?>
