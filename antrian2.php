<?php
$servername = "localhost";
$username = "root"; // Sesuaikan dengan nama pengguna database Anda
$password = "";     // Sesuaikan dengan kata sandi database Anda
$dbname = "nama_database_anda"; // Ubah dengan nama database yang Anda buat

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($username) || empty($email) || empty($password)) {
    echo "Semua kolom harus diisi.";
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Pendaftaran berhasil! <a href='login.html'>Silakan masuk</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
