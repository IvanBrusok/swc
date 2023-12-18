## Тестовое задание SWC backend developer

### Инструкция по запуску

Клонируем проект с репозитория
```angular2html
git clone https://github.com/IvanBrusok/swc.git
```

В первую очередь устанавливаем зависимости
```angular2html
composer install
```

Перед запуском необходимо клонировать .env.example в .env
```angular2html
cp .env.example .env
```

После необходимо в файле .env заменить параметры подключения к бд
```angular2html
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
И в конце запускаем миграции и сид данных
```angular2html
php artisan migrate --seed
```

Для запуска веб-сервера необходимо выполнить команду
```angular2html
php artisan serve
```

После запуска можно открыть [интерфейс](http://127.0.0.1:8000)
