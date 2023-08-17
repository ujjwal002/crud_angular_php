<?php
include 'config.php';
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");
$requestMethod = $_SERVER["REQUEST_METHOD"];
if ($requestMethod == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $_GET['id'];
    $first_name = trim($data['first_name']);
    $last_name = trim($data['last_name']);
    $email = $data['email'];
    $age = $data['age'];
    $gender = trim($data['gender']);
    $designation = trim($data['designation']);
    $joining_date = trim($data['joining_date']);
    $sql = "UPDATE employees SET first_name = '$first_name',last_name = '$last_name',email='$email',age= '$age',gender= '$gender',designation= '$designation',joining_date= '$joining_date' WHERE id = $id";
    $result = $link->query($sql);
    // print_r($sql);
    if ($result) {
        $data = ['status' => 1, 'message' => 'data insert succesfully','data'=>$result];
        header("HTTP/1.0 200 OK");
        echo json_encode($data);
    }
}
?>