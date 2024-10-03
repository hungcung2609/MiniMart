<?php

// Thay đổi key API của bạn tại đây
$api_key = 'e9e9d8da18ae29fc430845952232787c';

if (!isset($_GET['query'])) {
    echo json_encode([]);
    exit;
}

$query = urlencode($_GET['query']);
$url = "https://api.themoviedb.org/3/search/movie?api_key={$api_key}&query={$query}&language=vi";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "{}",
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo json_encode(["error" => "Curl Error: {$err}"]);
} else {
  $data = json_decode($response, true);
  if (isset($data['results'])) {
      $movies = [];
      foreach ($data['results'] as $movie) {
          $movies[] = [
              "id" => $movie['id'],
              "title" => $movie['title'],
              "image_path" => "https://image.tmdb.org/t/p/w500" . $movie['poster_path']
          ];
      }
      echo json_encode($movies);
  } else {
      echo json_encode([]);
  }
}
