import json
import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity

def get_recommendations(movie_id):
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
        rating_matrix = ratings_df.pivot_table(index='userId', columns='movieId', values='rating')

        # Calculate similarity between users based on ratings
        user_similarity_ratings = cosine_similarity(rating_matrix.fillna(0))

        # Calculate similarity between users based on movie genres
        # Create a genre matrix
        genre_matrix = pd.get_dummies(movies_df['genre_ids'].apply(pd.Series).stack(), prefix='genre').sum(level=0)

        # Calculate similarity between users based on genres
        user_similarity_genres = cosine_similarity(genre_matrix.fillna(0))

        # Combine similarities from both ratings and genres
        user_similarity_combined = user_similarity_ratings + user_similarity_genres

        # Find similar users
        similar_users = pd.Series(user_similarity_combined[movie_id]).sort_values(ascending=False).index[1:]

        # Get recommendations based on similar users' ratings and genres
        recommendations = []
        for user in similar_users:
            user_ratings = rating_matrix.loc[user]
            user_ratings = user_ratings[user_ratings.notnull()]
            for movie in user_ratings.index:
                if movie not in rating_matrix.loc[movie_id].dropna().index:
                    recommendations.append(movie)

        # Return up to 5 recommended movie IDs
        return json.dumps(recommendations[:5])

    except Exception as e:
        return json.dumps({"error": str(e)})

if __name__ == "__main__":
    import sys
    movie_id = int(sys.argv[1])
    recommendations = get_recommendations(movie_id)
    print(recommendations)
