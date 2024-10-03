import json
import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity

def get_recommendations(movie_id, user_id):
    try:
        # Load movies and ratings data from JSON files
        with open('movies.json', 'r', encoding='utf-8') as movies_file:
            movies_data = json.load(movies_file)

        with open('ratings.json', 'r', encoding='utf-8') as ratings_file:
            ratings_data = json.load(ratings_file)

        # Convert data into DataFrames
        movies_df = pd.DataFrame(movies_data)
        ratings_df = pd.DataFrame(ratings_data)

        # Create a pivot table of ratings
        rating_matrix = ratings_df.pivot_table(index='user_id', columns='movie_id', values='rating')

        # Check if movie_id exists in movies_df
        if movie_id not in movies_df['id'].values:
            return json.dumps({"error": f"movie_id {movie_id} not found in movies"})

        # Get genres of the selected movie
        selected_movie_genres = set(movies_df[movies_df['id'] == movie_id]['genre_ids'].values[0])

        # Create a similarity score for movies based on Jaccard index
        def calculate_jaccard_similarity(selected_genres, movie_genres):
            movie_genres_set = set(movie_genres)
            intersection = len(selected_genres.intersection(movie_genres_set))
            union = len(selected_genres.union(movie_genres_set))
            return intersection / union

        movies_df['genre_similarity'] = movies_df['genre_ids'].apply(lambda genres: calculate_jaccard_similarity(selected_movie_genres, genres))
        genre_similarity_scores = movies_df.set_index('id')['genre_similarity']

        # Filter movies that have at least one matching genre
        genre_similarity_scores = genre_similarity_scores[genre_similarity_scores > 0]

        # Check if there are any similar movies
        if genre_similarity_scores.empty:
            return json.dumps({"error": "No similar movies found based on genres"})

        # Calculate similarity between users based on ratings
        user_similarity_ratings = cosine_similarity(rating_matrix.fillna(0))

        # Map user_id to the correct index in user_similarity_ratings
        user_id_map = {user_id: idx for idx, user_id in enumerate(rating_matrix.index)}

        # Combine genre similarity with user rating similarity to get recommendations
        recommendations = []
        similar_users = []
        if user_id in user_id_map:
            user_index = user_id_map[user_id]
            similar_users = pd.Series(user_similarity_ratings[user_index], index=rating_matrix.index).sort_values(ascending=False).index[1:]
        
        for similar_user in similar_users:
            similar_user_index = user_id_map[similar_user]
            similar_user_ratings = rating_matrix.loc[similar_user]
            similar_user_ratings = similar_user_ratings[similar_user_ratings.notnull()]
            for similar_movie in similar_user_ratings.index:
                if similar_movie != movie_id and similar_movie in genre_similarity_scores.index and similar_movie not in [rec[0] for rec in recommendations]:
                    combined_score = genre_similarity_scores[similar_movie] + user_similarity_ratings[user_index][similar_user_index]
                    recommendations.append((similar_movie, combined_score))

        # Sort recommendations based on combined scores
        recommendations = sorted(recommendations, key=lambda x: x[1], reverse=True)
        recommended_movie_ids = [rec[0] for rec in recommendations[:8]]

        # Check if there are any recommended movies
        if not recommended_movie_ids:
            return json.dumps({"error": "No recommended movies found"})

        # Return up to 8 recommended movie IDs
        return json.dumps(recommended_movie_ids)

    except Exception as e:
        return json.dumps({"error": str(e)})

if __name__ == "__main__":
    import sys
    if len(sys.argv) < 3:
        print(json.dumps({"error": "Missing movie_id or user_id"}))
    else:
        movie_id = int(sys.argv[1])  # Lấy tham số dòng lệnh đầu tiên và chuyển đổi nó thành số nguyên
        user_id = int(sys.argv[2])   # Lấy tham số dòng lệnh thứ hai và chuyển đổi nó thành số nguyên
        recommendations = get_recommendations(movie_id, user_id)  # Gọi hàm get_recommendations với movie_id và user_id
        print(recommendations)  # In ra các đề xuất phim dưới dạng JSON
