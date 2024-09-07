# API server


## Установка

```sh
git clone https://github.com/backenddeveloper-lab/keepcode.git
cd main
composer install
cp .env.example .env
```

Измените конфигурацию подключения к базе данных в файле .env 

```sh
php artisan key:generate
php artisan migrate --seed
```

## Запуск локального сервера

```sh
php artisan serve
```

## API


Зарегистрировать аккаунт в приложении (при успешной регистраии вернет Bearer токен)
```sh
POST /api/register
```
Параметры
- 'email' : Почтовый ящик пользователя.
- 'password' : Пароль пользователя.

##

Получить Bearer токен
```sh
POST /api/login
```
Параметры
- 'email' : Почтовый ящик пользователя.
- 'password' : Пароль пользователя.

##

Уничтожить текущую сессию
```sh
POST /api/logout
```

##

Совершить покупку товара
```sh
POST /api/items/{item}/buy
```
Параметры
- '{item}' : идентификатор товара.

##

Арендовать товар (Если товар уже арендован вами, вы можете продлить аренду вызвав этот метод еще раз. Максимальное время аренды 24 часа)
```sh
POST /api/items/{item}/rent
```
Параметры
- '{item}' : идентификатор товара.
- 'duration' : колличество часов аренды (Максимум 24).

##

Получить статус товара
```sh
GET /api/items/{item}/rent
```

##

Получить все транзакции пользователя
```sh
GET /api/user/transactions
```
Параметры
- 'per_page' (опционально): количество транзакций на страницу (по умолчанию: 10).
- 'page' (опционально): конкретная страница пагинации.

