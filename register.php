<?php

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$ad = $data["ad_soyad"] ?? "";
$email = $data["email"] ?? "";
$password = $data["password"] ?? "";

if(!$ad || !$email || !$password){
    echo json_encode([
        "status" => "error",
        "message" => "Boş alan var"
    ]);
    exit;
}

$host = "localhost";
$db   = "database_adi";
$user = "db_kullanici";
$pass = "db_sifre";

try {

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);

    $stmt = $pdo->prepare("INSERT INTO users (full_name,email,password) VALUES (?,?,?)");

    $stmt->execute([
        $ad,
        $email,
        password_hash($password, PASSWORD_DEFAULT)
    ]);

    echo json_encode([
        "status" => "success"
    ]);

} catch(PDOException $e){

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);

}
