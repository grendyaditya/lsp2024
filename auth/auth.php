<?php

include '../config/db.php';

// Fungsi untuk mengecek apakah admin sudah login
function checkAuth()
{
    if (!isset($_SESSION['admin'])) {
        header('Location: ../views/login.php');
        exit();
    }
}

// Fungsi untuk login admin

function login($email, $password)
{
    global $conn;
    $password = md5($password); // Encrypt password
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = :email AND password = :password");
    $stmt->execute(['email' => $email, 'password' => $password]);

    if ($stmt->rowCount() > 0) {
        $admin = $stmt->fetch();
        $_SESSION['admin'] = $admin['nama']; // Simpan nama admin dalam session
        return true;
    }
    return false;
}
