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


## API
- см routes/api.php
