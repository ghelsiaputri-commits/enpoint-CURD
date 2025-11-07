<?php
include "../database.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode(["message" => "ID tidak ditemukan, hapus gagal!"]);
    exit;
}

$id = $data['id'];

$stmt = $conn->prepare("DELETE FROM User WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "message" => "User dengan ID $id berhasil dihapus"
        ]);
    } else {
        echo json_encode([
            "message" => "User dengan ID $id tidak ditemukan"
        ]);
    }
} else {
    echo json_encode(["message" => "Hapus gagal, terjadi kesalahan!"]);
}

$stmt->close();
$conn->close();
?>
