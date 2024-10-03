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

// Hàm để lấy số thứ tự mới cho người dùng
function getNextUserId($users) {
    // Lấy keys (số thứ tự) hiện có trong mảng người dùng
    $user_ids = array_keys($users);

    // Tìm số thứ tự cao nhất và tạo số thứ tự tiếp theo
    if (!empty($user_ids)) {
        $max_user_id = max($user_ids);
        return $max_user_id + 1;
    } else {
        return 1; // Nếu chưa có người dùng nào, trả về số thứ tự đầu tiên là 1
    }
}

// Xử lý khi POST dữ liệu từ form đăng ký
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu và mật khẩu xác nhận có khớp nhau không
    if ($password === $confirm_password) {
        // Đọc danh sách người dùng từ tệp JSON
        $jsonFilePath = 'users.json';
        $users = readUsersFromJSON($jsonFilePath);

        // Kiểm tra xem username đã tồn tại chưa
        if (array_key_exists($username, $users)) {
            $message = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.";
        } else {
            // Lấy số thứ tự mới cho người dùng
            $user_id = getNextUserId($users);

            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Thêm người dùng mới vào mảng $users
            $users[$user_id] = [
                "username" => $username,
                "password" => $hashed_password,
                "name" => $name
            ];

            // Ghi danh sách người dùng mới vào tệp JSON
            if (writeUsersToJSON($jsonFilePath, $users)) {
                $message = "Đăng ký thành công!";
            } else {
                $message = "Lỗi khi ghi vào tệp users.json";
            }
        }
    } else {
        $message = "Mật khẩu xác nhận không khớp.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000; /* Black background */
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('https://assets.bwbx.io/images/users/iqjWHBFdfxIU/ioUPyn34M7Hc/v0/-1x-1.jpg'); /* Add your background image here */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            color: #000; /* Text color inside the container */
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }
        input[type="text"], input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        p {
            color: red;
        }
        .links {
            margin-top: 10px;
        }
        .links a {
            text-decoration: none;
            color: #333;
            margin-right: 10px;
        }
        .home-link {
            position: absolute;
            top: 10px;
            left: 10px;
            padding :5px;
            text-decoration: none;
            color: #fff; /* White color for the "Trang chủ" link */
            font-size: 24px; /* Larger font size */
            background-color: #45a049
        }
        .title {
            font-size: 50px; /* Larger font size */
            margin-bottom: 20px;
        }
       
    </style>
</head>
<body>
    <a href="index.php" class="home-link">Trang chủ</a>
    <div class="title">Trang Web Xem Phim</div>
    <div class="container">
        <h2>Đăng Ký</h2>
        <form method="post" action="">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm_password">Xác nhận mật khẩu:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            <button type="submit">Đăng Ký</button>
        </form>
        <p><?php echo $message; ?></p>
        <div class="links">
            <a href="login.php">Đã có tài khoản? Đăng nhập ngay</a>
        </div>
    </div>
</body>
</html>
