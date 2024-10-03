<?php

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Đọc dữ liệu từ file users.json
    $json_data = file_get_contents('users.json');
    $users_data = json_decode($json_data, true);
    
    // Tìm kiếm người dùng trong users.json
    $authenticated = false;
    foreach ($users_data as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            // Đăng nhập thành công
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $user['name'];
            header('Location: index.php'); // Chuyển hướng về trang chủ
            exit();
        }
    }

    // Nếu không tìm thấy người dùng hoặc mật khẩu không đúng
    $message = "Tên đăng nhập hoặc mật khẩu không đúng.";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <style>
        /* CSS tùy chỉnh cho trang đăng nhập */
        body {
            font-family: Arial, sans-serif;
            background-color: #000; /* Màu nền đen */
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('https://assets.bwbx.io/images/users/iqjWHBFdfxIU/ioUPyn34M7Hc/v0/-1x-1.jpg'); /* Đặt hình nền của bạn ở đây */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Nền màu trắng mờ */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            color: #000; /* Màu văn bản bên trong */
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
        .home-link {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 5px;
            text-decoration: none;
            color: #fff; /* Màu trắng cho liên kết "Trang chủ" */
            font-size: 24px; /* Kích thước phông chữ lớn hơn */
            background-color: #45a049;
        }
        .title {
            font-size: 50px; /* Kích thước phông chữ lớn hơn */
            margin-bottom: 20px;
            color:#fff;
            background-color: #45a049
        }
    </style>
</head>
<body>
    <a href="index.php" class="home-link">Trang chủ</a>
    <div class="title">Trang Web Xem Phim</div>
    <div class="container">
        <h2>Đăng Nhập</h2>
        <form method="post" action="">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Đăng Nhập</button>
        </form>
        <p><?php echo $message; ?></p>
    </div>
</body>
</html>
