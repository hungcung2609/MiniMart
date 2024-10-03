<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Web Xem Phim</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .movie-list {
            display: flex;
            overflow-x: auto; /* Cho phép cuộn ngang khi có nhiều phim */
            scroll-behavior: smooth; /* Hiệu ứng chuyển động mượt mà */
            white-space: nowrap; /* Không ngắt dòng */
            gap: 20px; /* Khoảng cách giữa các phim */
            padding: 10px 0;
        }

        .movie-item {
            flex: 0 0 auto;
            width: 200px; /* Độ rộng của mỗi phim */
            transition: transform 0.5s ease; /* Hiệu ứng chuyển động */
        }

        .movie-item:hover {
            transform: scale(1.1); /* Phóng to phim khi hover */
        }
    </style>
</head>

<body>
<header>
    <h1>Trang Web Xem Phim</h1>
    <!-- Thanh tìm kiếm -->
    <form id="search-form" class="search-form">
        <input type="text" name="query" id="query" placeholder="Tìm kiếm phim...">
        <button type="submit">Tìm kiếm</button>
    </form>
    <?php
    session_start();

    // Kiểm tra xem session đã được thiết lập và có chứa thông tin người dùng không
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $name = $_SESSION['name'];
        echo "<div class='header-left'>
                <h3>Xin chào người dùng: $name</h3>
              </div>
              <div class='header-right'>
                <a href='logout.php'>Đăng xuất</a>
              </div>";
    } else {
        // Hiển thị nút đăng nhập và đăng ký nếu chưa đăng nhập
        echo "<div class='header-right'>
                <a href='login.php'>Đăng nhập</a>
                <a href='register.php'>Đăng ký</a>
              </div>";
    }
    ?>
</header>

<div class="container">
    <section class="new-movies">
        <h2 class="section-title">Phim Mới</h2>
        <div class="movie-list" id="new-movie-slider">
            <!-- Các phim mới sẽ được thêm bằng JavaScript -->
        </div>
    </section>

    <section class="all-movies">
        <h2 class="section-title">Tất Cả Các Phim</h2>
        <div class="movie-list1" id="all-movies">
            <!-- Các phim từ cơ sở dữ liệu MySQL sẽ được thêm bằng PHP -->
            <?php
            // Đọc dữ liệu từ file JSON 'movies.json'
            $json_data = file_get_contents('movies.json');
            $movies = json_decode($json_data, true);

            // Hiển thị danh sách phim từ JSON
            if (!empty($movies)) {
                foreach ($movies as $movie) {
                    $img_path = "https://image.tmdb.org/t/p/original" . $movie["poster_path"]; // Thêm đường dẫn đầy đủ của poster_path
                    echo "<div class='movie-item'>";
                    echo "<img src='" . $img_path . "' alt='" . $movie["title"] . "'>";
                    echo "<h3>" . $movie["title"] . "</h3>";
                    echo "<a href='view.php?id=" . $movie["id"] . "'>Xem</a>";
                    echo "</div>";
                }
            } else {
                echo "Không có kết quả phim nào.";
            }
            ?>
        </div>
    </section>

    <section class="recommended-movies">
        <h2 class="section-title">Phim Đề Xuất</h2>
        <div class="movie-list2" id="recommended-movies">
            <!-- Các phim đề xuất từ API sẽ được thêm bằng JavaScript -->
        </div>
    </section>
</div>

<script>
    // JavaScript để lấy và hiển thị danh sách phim mới và phim đề xuất
    window.onload = function() {
        const newMovieSlider = document.getElementById('new-movie-slider');
        const recommendedMoviesContainer = document.getElementById('recommended-movies');

        // Đọc danh sách phim từ file JSON 'movies.json'
        fetch('movies.json')
            .then(response => response.json())
            .then(data => {
                // Lấy 5 phim đầu tiên làm phim mới
                const newMovies = data.slice(0, 5);

                newMovies.forEach(movie => {
                    const imgPath = "https://image.tmdb.org/t/p/original" + movie.poster_path;
                    const movieItem = document.createElement('div');
                    movieItem.classList.add('movie-item');
                    movieItem.innerHTML = `
                        <img src="${imgPath}" alt="${movie.title}">
                        <h3>${movie.title}</h3>
                        <a href="view.php?id=${movie.id}">Xem</a>
                    `;
                    newMovieSlider.appendChild(movieItem);
                });

                // Tự động chuyển động từ phải qua trái
                setInterval(() => {
                    const firstMovie = newMovieSlider.firstElementChild;
                    newMovieSlider.removeChild(firstMovie);
                    newMovieSlider.appendChild(firstMovie);
                }, 3000); // Thời gian chuyển động mỗi 3 giây

                // Lấy top 5 phim có vote_average cao nhất làm phim đề xuất
                const topRatedMovies = data.sort((a, b) => b.vote_average - a.vote_average).slice(0, 5);

                topRatedMovies.forEach(movie => {
                    const imgPath = "https://image.tmdb.org/t/p/original" + movie.poster_path;
                    const movieItem = document.createElement('div');
                    movieItem.classList.add('movie-item');
                    movieItem.innerHTML = `
                        <img src="${imgPath}" alt="${movie.title}">
                        <h3>${movie.title}</h3>
                        <a href="view.php?id=${movie.id}">Xem</a>
                    `;
                    recommendedMoviesContainer.appendChild(movieItem);
                });
            })
            .catch(error => console.error('Error fetching movies:', error));
    };
    document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = document.getElementById('query').value.trim();
        if (query !== '') {
            window.location.href = `search.php?query=${query}`;
        }
    });
</script>

</body>
</html>
