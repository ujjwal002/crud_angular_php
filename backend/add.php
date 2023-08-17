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
        $id = $_POST["id"];
        $first_name = trim($data['first_name']);
        $last_name = trim($data['last_name']);
        $email = $data['email'];
        $age = $data['age'];
        $gender = trim($data['gender']);
        $designation = trim($data['designation']);
        $joining_date = trim($data['joining_date']);
        if (!empty($email)) {
            $sql = "SELECT * FROM `employees` WHERE `email` = '" . $email . "'";
            $result = $link->query($sql);
            $present_row_count_in_db = mysqli_num_rows($result);
            if ($present_row_count_in_db > 0) {
                $data = ['status' => 0, 'result' => 'Employee Already Exist'];
                echo json_encode($data);
            } else if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($age) && !empty($gender)&& !empty($designation)&& !empty($joining_date)) {
                $sql = "INSERT INTO `employees` (first_name, last_name, email, age, gender,designation,joining_date)
                VALUES ('" . $first_name . "' , '" . $last_name . "', '" . $email . "', '" . $age . "', '" . $gender . "','" . $designation . "','" . $joining_date . "');";

                $result = $link->query($sql);
                // die($result);
                $data = ['status' => 1, 'result' => 'data insert sucessfully'];
                echo json_encode($data);


            }
        } else {
            $data = ['status' => 0, 'result' => 'User Already Exist'];
            echo json_encode($data);
        }
    }

} catch (\Throwable $th) {
    echo $th;
}

?>