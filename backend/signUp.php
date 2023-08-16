<?php
include 'config.php';
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");
$requestMethod = $_SERVER["REQUEST_METHOD"];
try {
    if ($requestMethod == "POST") {
        $data = json_decode(file_get_contents("php://input"), true);
        $name = trim($data['name']);
        $email = trim($data['email']);
        $phone = trim($data['phone']);
        $password = trim($data['password']);
        $image = trim($data['image']);
        if (!empty($email)) {
            $sql = "SELECT * FROM `register` WHERE `email` = '" . $email . "'";
            $result = $link->query($sql);
            $present_row_count_in_db = mysqli_num_rows($result);
            if ($present_row_count_in_db > 0) {
                $data = ['status' => 0, 'result' => 'User Already Exist'];
                echo json_encode($data);
            } else if (!empty($name) && !empty($email) && !empty($password) && !empty($phone) && !empty($image)) {
                $sql = "INSERT INTO `register` (name, email, phone, password, image)
                VALUES ('".$name."' , '".$email."', '".$phone."', '".$password."', '".$image."');";
            
                $result = $link->query($sql);
                //die($result);
                $data = ['status' => 1, 'result' => 'data insert sucessfully'];
                echo json_encode($data);


            }
        } else {
            $data = ['status' => 0, 'result' => 'User Already Exist'];
            echo json_encode($data);
        }
    }

} catch (\Throwable $th) {
    echo $th->getMessage();
}

?>