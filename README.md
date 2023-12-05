# Тест проект Ракета

### ENV
создать .env (например из .env.example)

выполнить успешно следующие команды:

    composer install
    ./vendor/bin/sail build --no-cache
    ./vendor/bin/sail up
    ./vendor/bin/sail artisan sail:publish
    ./vendor/bin/sail artisan vendor:publish
    ./vendor/bin/sail artisan cache:clear
    ./vendor/bin/sail artisan vars #проверка env записей
    ./vendor/bin/sail artisan config:cache
    ./vendor/bin/sail artisan migrate
    ./vendor/bin/sail artisan db:seed

открыть страницу проекта [http://localhost/login](http://localhost/login)
произвести авторизацию пользователем "manager" (пароль 123)