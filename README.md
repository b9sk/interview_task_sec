Исходная задача https://gist.github.com/f1uder/91f428ceedcc7ea8ef66a71b2128b9f7


### Системные требования перед установкой
- Docker Compose

В Windows 10+ нужно использовать WSL2, то есть:
- запускать Docker Compose через WSL2
- хранить файлы проекта в WSL2


### Первый запуск
????
```bash
docker compose up -d

./artisan.sh migrate
./artisan.sh db:seed UserSeeder
```
вообще пока не понятно как это делать, стратегия так сказщать

После docker compose up
./artisan.sh migrate
./artisan.sh db:seed UserSeeder