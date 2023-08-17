<?php
include 'config.php';
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");
$requestMethod = $_SERVER["REQUEST_METHOD"];
session_start();
if (isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true) {
    if ($requestMethod == "GET") {
        $id = $_GET['id'];
        $sql = "SELECT * FROM register where id=$email and password='$password'";
        $result = $link->query($sql);
        $total_row = mysqli_num_rows($result);
        if ($total_row > 0) {
            $row = mysqli_fetch_assoc($result);
            $data = [
                'status' => 1,
                'message' => $requestMethod . ' Succesfully',
                'data' => $row,
            ];
            header("HTTP/1.0 200 Succeses");
            echo json_encode($data);
        } else {
            $data = [
                'status' => 0,
                'message' => $requestMethod . 'User not foound',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => 0,
            'message' => $requestMethod . 'Thier is on sever side',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }
} else {
    $data = [
        'status' => 0,
        'message' => 'User not logged in',
    ];
    header("HTTP/1.0 401 Unauthorized");
    echo json_encode($data);
}
?>