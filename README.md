<div style="text-align: center">

# Photogram

### A simple social network for photos

</div>

## Prerequisites

To run this project, you will need to have installed on your machine the following tools:

- [PHP](https://www.php.net/downloads.php) >= 8.1 (recommended: 8.2)
- [MySQL](https://dev.mysql.com/downloads/mysql/) >= 8.0 or [MariaDB](https://mariadb.org/download/) >= 10.5
- [Composer](https://getcomposer.org/download/)

To build the assets, you will need to have installed on your machine the following tools:

- [Node.js](https://nodejs.org/en/download/) >= 19
- [PNPM](https://pnpm.io/installation) >= 7.18.2

> We suggest to install PNPM via corepack to sync it with the project's version

## Installation

To install this project, you will need to clone this repository and install the dependencies:

```bash
git clone https://github.com/maicol07/photogram.git # Clone the repository
cd photogram
composer install # Install PHP dependencies
pnpm install # Install CSS/JS dependencies
```

> Composer may give you some errors related to missing PHP extensions (such as `bcmath`). If that's the case, you will need to install them.

### Build assets

To build the assets, you will need to run the following command:

```bash
pnpm build
```

> This will compile SCSS into CSS, combine JS files and their dependencies (this is called bundling) and publish the resulting files (a .css file and a .js file) in the `public/build` directory.

## Configuration

To configure this project, you will need to copy a `.env` file in the root of the project:

```bash
cp .env.example .env
php artisan key:generate # Generate the application key
php artisan storage:link # Create a symbolic link from "public/storage" to "storage/app/public" to make the files in the "public/storage" directory accessible from the web
php artisan vendor:publish --tag=blade-flags --force # Publish the flags images provided by blade-flags to the public directory
```

> If the `APP_KEY`  The application key is used by the Laravel framework to encrypt data.

Then, you will need to configure the app settings and the database connection in the `.env` file by setting
the `DB_*` and `APP_*` variables.

## Database

To create the database, you will need to run the following command after configuring the database connection in
your `.env` file:

```bash
php artisan migrate
```

> This will create the database tables (detailed: runs the migrations in the `database/migrations` directory).

## Usage

Before running the project, you will need to build the assets and migrate the database (see above).

### Development

To run the PHP development server for the project, you will need to run the following command:

```bash
php artisan serve
```

> This will start a development PHP server at port 8000 (default).

### Production

You can run the project in production by your favorite web server (Apache, Nginx, etc.). The entry point of the
project is the `public/index.php` file, so you need to point your web document root to `$PROJECT_DIR/public`.

## Development

To watch files and automatically refresh the page when these changes (development mode), you will need to run the following command:

```bash
pnpm dev
```

> This will start the [Vite dev server](https://vitejs.dev/guide/) on port 5173 (default).

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

You can also create a single run configuration for both commands (after adding the two configurations above separately),
using the Multirun plugin:

- **Name**: Serve & Dev
- **Type**: Multirun
- **Run configurations**: `Serve`, `Dev`
- **Start configurations one by one**: `false`
