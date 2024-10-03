import requests
import random
import bcrypt  # Import thư viện bcrypt
import json

# API key từ TMDb
API_KEY = 'e9e9d8da18ae29fc430845952232787c'
BASE_URL = 'https://api.themoviedb.org/3'

# Danh sách tên ngẫu nhiên
first_names = ['John', 'Jane', 'Mike', 'Emily', 'Robert', 'Linda', 'David', 'Lisa', 'James', 'Mary']
last_names = ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor']

# Hàm lấy danh sách phim từ TMDb
def get_movies(api_key, page=1):
    url = f'{BASE_URL}/movie/popular?api_key={api_key}&language=en-US&page={page}'
    response = requests.get(url)
    if response.status_code == 200:
        return response.json().get('results', [])
    else:
        return []

# Hàm tạo người dùng ngẫu nhiên
def create_users(num_users):
    users = []
    for i in range(1, num_users + 1):
        username = f'user{i}'
        password = username.encode('utf-8')  # Chuyển đổi chuỗi thành bytes
        hashed_password = bcrypt.hashpw(password, bcrypt.gensalt())  # Mã hóa mật khẩu
        fullname = f'{random.choice(first_names)} {random.choice(last_names)}'
        users.append({
            'user_id': i,
            'username': username,
            'password': hashed_password.decode('utf-8'),  # Chuyển đổi bytes thành chuỗi
            'name': fullname
        })
    return users

# Hàm tạo đánh giá ngẫu nhiên
def create_ratings(num_users, num_movies, num_ratings):
    ratings = []
    for _ in range(num_ratings):
        user_id = random.randint(1, num_users)
        movie_id = random.randint(1, num_movies)
        rating = random.randint(1, 5)
        ratings.append({
            'user_id': user_id,
            'movie_id': movie_id,
            'rating': rating
        })
    return ratings

# Số lượng người dùng, phim và đánh giá
num_users = 100
num_movies = 200
num_ratings = 10000

# Tạo người dùng ngẫu nhiên
users = create_users(num_users)

# Lấy danh sách phim từ TMDb
movies = []
for page in range(1, (num_movies // 20) + 1):
    movies.extend(get_movies(API_KEY, page))

# Giới hạn danh sách phim theo số lượng yêu cầu
movies = movies[:num_movies]

# Tạo đánh giá ngẫu nhiên
ratings = create_ratings(num_users, num_movies, num_ratings)

# Lưu người dùng, phim và đánh giá vào file JSON
with open('users.json', 'w') as f:
    json.dump(users, f, indent=4)

with open('movies.json', 'w') as f:
    json.dump(movies, f, indent=4)

with open('ratings.json', 'w') as f:
    json.dump(ratings, f, indent=4)

print('Đã lưu dữ liệu người dùng, phim và đánh giá vào file JSON')
