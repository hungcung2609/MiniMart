<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm phim</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .movie-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px 0;
        }

        .movie-item {
            width: 200px;
            transition: transform 0.5s ease;
        }

        .movie-item:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
<header>
    <h1>Kết quả tìm kiếm phim</h1>
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
        const movieList = document.getElementById('searched-movies');
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get('query');

        if (query) {
            fetch('movies.json')
                .then(response => response.json())
                .then(data => {
                    movieList.innerHTML = '';
                    const filteredMovies = data.filter(movie =>
                        movie.title.toLowerCase().includes(query.toLowerCase())
                    );
                    if (filteredMovies.length > 0) {
                        filteredMovies.forEach(movie => {
                            const imgPath = "https://image.tmdb.org/t/p/original" + movie.poster_path;
                            const movieItem = `
                                <div class='movie-item'>
                                    <img src='${imgPath}' alt='${movie.title}'>
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
</script>

</body>
</html>
