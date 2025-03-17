# HomeBookLibrary 📚

HomeBookLibrary is an online library for storing and searching books.

## 🚀 Features

-   Book search and cataloging.
-   User management.
-   Categories and tags system.
-   Save favorite books.
-   Search by book name, author, genre and series.
-   Leave comments and rate books.

## 🛠 How to Run Locally

```bash
git clone https://github.com/aleksandrvasilyev/home-book-library.git
cd home-book-library
```

### Install dependencies

```bash
composer install
npm install
```

### Create the .env configuration file

```bash
cp .env.example .env
```

### Generate an application key

```bash
php artisan key:generate
```

### Configure the database

Edit the .env file and update the database settings:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homebooklibrary
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### Run migrations

```bash
php artisan migrate --seed
```

### Start the server

```bash
php artisan serve
```

Your project will be available at <http://127.0.0.1:8000>.
