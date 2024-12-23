Исходная задача https://gist.github.com/f1uder/91f428ceedcc7ea8ef66a71b2128b9f7

## Установка

### Системные требования перед установкой
- Docker Compose

В Windows 10+ нужно использовать WSL2, то есть:
- запускать Docker Compose через WSL2
- хранить файлы проекта в WSL2


### Первый запуск

Клонировать ветку master из репозитория:
`git clone https://github.com/b9sk/interview_task_sec.git -b master`

Скопировать `.env.example` в `.env`.

Выполнить `docker compose up -d` и дождаться, когда контейнеры будут готовы.

Создать таблицы и наполнить users тестовыми данными из UserSeeder:
`./artisan.sh migrate --seed`.

#### Проверка

Выполнить  `./artisan.sh test`, пройти все тесты.

Перейти на http://localhost:8080, получить 200.


## API Documentation

### Base URL
```
{{HOST}} = http://localhost:8080
```

### Endpoints

#### Get Users
- **URL:** `/api/users`
- **Method:** `GET`
- **Query Parameters:**
  - `page` (optional): Page number for pagination.
  - `name` (optional): Filter users by name.
  - `order` (optional): Order by name, values can be `asc` or `desc`.
- **Response:**
  - **Status:** `200 OK`
  - **Body:**
    ```json
    {
      "data": [
        {
          "id": 1,
          "name": "John Doe",
          "email": "john@example.com",
          "created_at": "2023-01-01T00:00:00.000000Z",
          "updated_at": "2023-01-01T00:00:00.000000Z"
        },
        ...
      ],
      "links": {
        "first": "...",
        "last": "...",
        "prev": null,
        "next": "..."
      },
      "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "...",
        "per_page": 20,
        "to": 1,
        "total": 1
      }
    }
    ```

#### Get User by ID
- **URL:** `/api/users/{id}`
- **Method:** `GET`
- **Response:**
  - **Status:** `200 OK`
  - **Body:**
    ```json
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

#### Create User
- **URL:** `/api/users`
- **Method:** `POST`
- **Body:**
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "comment": "This is a comment",
    "ip": "127.0.0.1"
  }
  ```
- **Response:**
  - **Status:** `201 Created`
  - **Body:**
    ```json
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

#### Update User
- **URL:** `/api/users/{id}`
- **Method:** `PUT`
- **Body:**
  ```json
  {
    "name": "John Doe",
    "password": "newpassword"
  }
  ```
- **Response:**
  - **Status:** `200 OK`
  - **Body:**
    ```json
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

#### Delete User
- **URL:** `/api/users/{id}`
- **Method:** `DELETE`
- **Response:**
  - **Status:** `204 No Content`

### Example Usage

#### Get Users
```sh
curl -X GET "{{HOST}}/api/users?page=1"
```

#### Get User by ID
```sh
curl -X GET "{{HOST}}/api/users/1"
```

#### Create User
```sh
curl -X POST "{{HOST}}/api/users" -H "Content-Type: application/json" -d '{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "comment": "This is a comment",
  "ip": "127.0.0.1"
}'
```

#### Update User
```sh
curl -X PUT "{{HOST}}/api/users/1" -H "Content-Type: application/json" -d '{
  "name": "John Doe",
  "password": "newpassword"
}'
```

#### Delete User
```sh
curl -X DELETE "{{HOST}}/api/users/1"
```

Similar code found with 1 license type
