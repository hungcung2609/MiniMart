<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm phim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Kết quả tìm kiếm phim</h1>
    
    <!-- Thanh tìm kiếm -->
    <form id="search-form" class="search-form">
        <input type="text" id="query" name="query" placeholder="Tìm kiếm phim...">
        <button type="submit">Tìm kiếm</button>
    </form>
</header>

<div class="container">
    <section class="search-results">
        <h2 class="section-title">Kết Quả Tìm Kiếm</h2>
        <div class="movie-list" id="searched-movies">
            <!-- Dữ liệu phim sẽ được hiển thị ở đây -->
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('search-form');
        const searchInput = document.getElementById('query');
        const movieList = document.getElementById('searched-movies');

        searchForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn chặn gửi biểu mẫu mặc định
            const query = searchInput.value.trim();
            if (query !== '') {
                fetch('movies.json')
                    .then(response => response.json())
                    .then(data => {
                        movieList.innerHTML = ''; // Xóa nội dung hiện tại của danh sách phim
                        const filteredMovies = data.filter(movie =>
                            movie.title.toLowerCase().includes(query.toLowerCase())
                        );
                        if (filteredMovies.length > 0) {
                            filteredMovies.forEach(movie => {
                                const movieItem = `
                                    <div class='movie-item'>
                                        <img src='${movie.poster_path}' alt='${movie.title}'>
                                        <h3>${movie.title}</h3>
                                        <a href='view.php?id=${movie.id}'>Xem</a>
                                    </div>
                                `;
                                movieList.insertAdjacentHTML('beforeend', movieItem);
                            });
                        } else {
                            movieList.innerHTML = 'Không có kết quả phù hợp.';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                        movieList.innerHTML = 'Đã xảy ra lỗi khi tải dữ liệu.';
                    });
            } else {
                movieList.innerHTML = 'Vui lòng nhập từ khóa tìm kiếm.';
            }
        });
    });
</script>

</body>
</html>
