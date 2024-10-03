<?php
session_start(); // Start session

// Function to read genres from genres.json
function readGenresFromJSON($jsonFilePath) {
    $genres = [];
    $json_data = file_get_contents($jsonFilePath);
    if ($json_data !== false) {
        $genres_data = json_decode($json_data, true);
        if (isset($genres_data['genres']) && is_array($genres_data['genres'])) {
            foreach ($genres_data['genres'] as $genre) {
                $genres[$genre['id']] = $genre['name'];
            }
        }
    }
    return $genres;
}

// Function to fetch movie details from movies.json by ID
function fetchMovieDetails($movie_id, $jsonFilePath) {
    $json_data = file_get_contents($jsonFilePath);
    if ($json_data !== false) {
        $movies_data = json_decode($json_data, true);
        if (is_array($movies_data)) {
            foreach ($movies_data as $movie) {
                if ($movie['id'] == $movie_id) {
                    return $movie;
                }
            }
        }
    }
    return null; // Return null if movie ID is not found
}

// Function to recommend similar movies based on content (genres)
function recommendSimilarMovies($selected_movie, $all_movies, $limit = 8) {
    $similar_movies = [];
    $selected_genres = $selected_movie['genre_ids'];
    
    foreach ($all_movies as $movie) {
        // Skip the same movie and movies without genres
        if ($movie['id'] == $selected_movie['id'] || empty($movie['genre_ids'])) {
            continue;
        }
        
        // Calculate Jaccard similarity between genres
        $intersection = array_intersect($selected_genres, $movie['genre_ids']);
        $union = array_unique(array_merge($selected_genres, $movie['genre_ids']));
        $jaccard_similarity = count($intersection) / count($union);
        
        // Consider movies with a reasonable similarity threshold (e.g., 0.2)
        if ($jaccard_similarity >= 0.4) {
            $similar_movies[] = $movie;
        }
        
        // Limit the number of similar movies to the specified limit
        if (count($similar_movies) >= $limit) {
            break;
        }
    }
    
    return $similar_movies;
}

// Define path to your JSON files
$genresJsonFilePath = 'genres.json'; // Replace with your actual genres.json file path
$moviesJsonFilePath = 'movies.json'; // Replace with your actual movies.json file path

// Read genres data from genres.json
$genres = readGenresFromJSON($genresJsonFilePath);

// Get movie ID from URL parameter
if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];

    // Save last viewed movie ID to session
    $_SESSION['last_viewed_movie'] = $movie_id;

    // Fetch movie details from movies.json by ID
    $selected_movie = fetchMovieDetails($movie_id, $moviesJsonFilePath);

    if ($selected_movie) {
        $title = $selected_movie['title'];
        $poster_path = "https://image.tmdb.org/t/p/original" . $selected_movie['poster_path']; // Prepend URL
        $release_date = $selected_movie['release_date']; // Release date
        $vote_average = $selected_movie['vote_average']; // Vote average
        
        // Map genre IDs to genre names
        $genre_names = [];
        foreach ($selected_movie['genre_ids'] as $genre_id) {
            if (isset($genres[$genre_id])) {
                $genre_names[] = $genres[$genre_id];
            }
        }
        $genre = implode(', ', $genre_names);

        $description = $selected_movie['overview'];

        // Display movie details
        echo '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết phim</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Custom CSS for movie details page */
        .container {
            padding: 0px;
        }
        .movie-detail {
            margin-top: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .movie-detail img {
            width: 20%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .movie-detail h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .movie-detail p {
            font-size: 16px;
            line-height: 1.6;
        }
        .back-button {
            margin-top: 10px;
        }
        .back-button a {
            display: inline-block;
            padding: 8px 16px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .recommended-movies {
            margin-top: 20px;
        }
        .recommended-movies .section-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .recommended-movies .movie-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 10px;
        }
        .recommended-movies .movie-item {
            flex-basis: 20%;
            margin-bottom: 20px;
            text-align: center;
        }
        .recommended-movies .movie-item img {
            width: 100%;
            border-radius: 5px;
        }
        .recommended-movies .movie-item h3 {
            margin-top: 10px;
            font-size: 16px;
        }
        .recommended-movies .movie-item a {
            display: inline-block;
            padding: 6px 12px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<header>
    <h1>Chi tiết phim</h1>
</header>

<div class="container">
    <div class="movie-detail">
        <h2>' . $title . '</h2>
        <img src="' . $poster_path . '" alt="' . $title . '">
        <p><strong>Ngày phát hành:</strong> ' . $release_date . '</p>
        <p><strong>Điểm đánh giá:</strong> ' . $vote_average . '</p>
        <p><strong>Thể loại:</strong> ' . $genre . '</p>
        <p><strong>Mô tả:</strong> ' . $description . '</p>
        <div class="back-button"><a href="index.php">Quay lại</a></div>
    </div>';

    // Recommend similar movies based on content (genres)
    $all_movies_data = json_decode(file_get_contents($moviesJsonFilePath), true);
    $similar_movies = recommendSimilarMovies($selected_movie, $all_movies_data);

    // Display recommended movies if available
    echo '<section class="recommended-movies">
        <h2 class="section-title">Phim Tương Tự</h2>';

    if (!empty($similar_movies)) {
        echo '<div class="movie-list">';
        foreach ($similar_movies as $movie) {
            $poster_path = "https://image.tmdb.org/t/p/original" . $movie['poster_path']; // Prepend URL
            echo "<div class='movie-item'>";
            echo "<img src='$poster_path' alt='{$movie['title']}'>";
            echo "<h3>{$movie['title']}</h3>";
            echo "<a href='view.php?id={$movie['id']}'>Xem</a>";
            echo "</div>";
        }
        echo '</div>';
    } else {
        echo '<p>Không có phim tương tự cho phim này.</p>';
    }

    echo '</section>
</div>

</body>
</html>';

    } else {
        echo "<p>Không tìm thấy thông tin phim.</p>";
    }
} else {
    echo "<p>Thiếu thông tin ID phim.</p>";
}
?>
