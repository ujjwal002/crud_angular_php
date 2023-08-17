<?php
include 'config.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");

session_start();
if (isset($_SESSION['loggedinn']) || $_SESSION['loggedinn'] == true) {
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    if ($requestMethod == "GET") {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        if (!empty($searchTerm)) {
            $searchTerm = mysqli_real_escape_string($link, $searchTerm);
            $sql = "SELECT * FROM employees WHERE first_name LIKE '%$searchTerm%' OR last_name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%' or age LIKE '%$searchTerm%'";
        } else {
            $recordsPerPage = 8;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $recordsPerPage;
            $sql = "SELECT * FROM employees Limit 10";
            $result = $link->query($sql);
            $total_row = mysqli_num_rows($result);
            if ($total_row > 0) {
                $data_array = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($data_array, $row);
                }
                $data = [
                    'status' => 1,
                    'message' => $requestMethod . 'Succesfully',
                    'data' => $data_array,
                ];
                header("HTTP/1.0 200 Succeses");
                echo json_encode($data);
            } else {
                header("HTTP/1.0 404 Not Found");
                echo json_encode($data);
            }
        }

    } else {
        $data = [
            'status' => 405,
            'message' => $requestMethod . 'method no found',
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