<?php
// Hàm để đọc người dùng từ tệp JSON
function readUsersFromJSON($jsonFilePath) {
    $users = [];
    $json_data = file_get_contents($jsonFilePath);
    if ($json_data !== false) {
        $users = json_decode($json_data, true);
    }
    return $users;
}

// Hàm để ghi danh sách người dùng vào tệp JSON
function writeUsersToJSON($jsonFilePath, $users) {
    $json_data = json_encode($users, JSON_PRETTY_PRINT);
    return file_put_contents($jsonFilePath, $json_data) !== false;
}
?>
