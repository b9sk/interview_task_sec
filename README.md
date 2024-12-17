Исходная задача https://gist.github.com/f1uder/91f428ceedcc7ea8ef66a71b2128b9f7

## Установка

### Системные требования перед установкой
- Docker Compose

В Windows 10+ нужно использовать WSL2, то есть:
- запускать Docker Compose через WSL2
- хранить файлы проекта в WSL2


### Первый запуск

Скопировать `.env.example` в `.env`.

Выполнить `docker compose up -d` и дождаться, когда контейнеры будут готовы.

Создать таблицы и наполнить users тестовыми данными: `./artisan.sh migrate --seed`

Перейти на http://localhost:8080, получить 200.


## API

### User

Пример объекта User, который вернет каждый метод:

```json
{
    "id": 1,
    "name": "John Doe",
    "email": "7E7yB@example.com",
    "ip": "127.0.0.1",
    "comment": "A lovely user!",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
}
```
Пароль и токен не возвращаются.

#### `GET /api/users`
Возвращает список пользователей. Используется пагинация Laravel.

__Get-параметры__:
- `page?: int` - номер страницы
- `name?: string` - поиск по имени пользователя или по части имени
TODO
- `order?: "asc"|"desc"` - поле для сортировки

#### `GET /api/users/{id}`
Информация о пользователе

#### `POST /api/users`
Создать пользователя

__Headers:__
Content-Type: `application/json` (обязательно)

__Поля__:
- `name: string` - имя пользователя
- `email: string` - email пользователя
- `password: string` - пароль 
- `ip?: string` - ip-адрес
- `comment?: string` - комментарий

#### `PUT /api/users/{id}`
Обновить пользователя по id. Поля такие же как в `POST /api/users` выше

#### `DELETE /api/users/{id}`
Удалить пользователя по id