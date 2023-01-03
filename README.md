<div style="text-align: center">

# Photogram
### A simple social network for photos
</div>

## Prerequisites
To run this project, you will need to have installed on your machine the following tools:
- [PHP](https://www.php.net/downloads.php) >= 8.2
- [MySQL](https://dev.mysql.com/downloads/mysql/) >= 8.0 or [MariaDB](https://mariadb.org/download/) >= 10.5
- [Composer](https://getcomposer.org/download/)

To build the assets, you will need to have installed on your machine the following tools:
- [Node.js](https://nodejs.org/en/download/) >= 19
- [PNPM](https://pnpm.io/installation) >= 7.18.2

## Installation
To install this project, you will need to clone this repository and install the dependencies:
```bash
git clone https://github.com/maicol07/photogram.git
cd photogram
composer install
pnpm install
```

### Build assets
To build the assets, you will need to run the following command:
```bash
pnpm build
```

## Configuration
To configure this project, you will need to copy a `.env` file in the root of the project:
```bash
cp .env.example .env
php artisan key:generate
```

Then, you will need to configure the app settings and the database connection in the `.env` file by setting
the `DB_*` and `APP_*` variables.

## Database
To create the database, you will need to run the following command:
```bash
php artisan migrate
```

## Usage
To run this project, you will need to run the following command:
```bash
php artisan serve
```

## Development
To run this project in development mode, you will need to run the following command:
```bash
pnpm dev
```

## PHPStorm tips
To run the `php artisan serve` command, you can add the following run configuration:
- **Name**: Serve
- **Type**: PHP Script
- **File**: `artisan`
- **Arguments**: `serve`

To run the `pnpm dev` command, you can add the following run configuration:
- **Name**: Dev
- **Type**: NPM
- **Package manager**: pnpm
- **Command**: `run`
- **Scripts**: `dev`
