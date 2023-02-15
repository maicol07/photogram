<div style="text-align: center">

# Photogram

### A simple social network for photos

</div>

## Prerequisites

To run this project, you will need to have installed on your machine the following tools:

- [PHP](https://www.php.net/downloads.php) >= 8.1 (recommended: 8.2)
  - [Mysql](https://www.php.net/manual/en/mysql.installation.php) extension
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
composer install --no-dev --optimize-autoloader # Install PHP dependencies
pnpm install # Install CSS/JS dependencies
```

> Composer may give you some errors related to missing PHP extensions (such as `bcmath`). If that's the case, you will need to install them.

After installation, to get a list of required PHP extensions, you can run the following command:
```bash
composer check-platform-reqs
```
This will list all the required PHP extensions and their versions. You can install them with your favorite package manager (apt, yum, etc.).
You'll need them to run the project without issues.

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
php artisan key:generate # Generate the application key for encryption operations
php artisan storage:link # Create a symbolic link from "public/storage" to "storage/app/public" to make the files in the "public/storage" directory accessible from the web
```

> If the `APP_KEY`  The application key is used by the Laravel framework to encrypt data.

Then, you will need to configure the app settings and the database connection in the `.env` file by setting
the `DB_*` and `APP_*` variables.
### Details
#### App settings
To configure the app settings, you have to set the `APP_*` variables in .env file with the following values:
- `APP_NAME`: The name of the app
- `APP_URL`: The URL of the app
- `APP_ENV`: The environment of the app (local, production, etc.)
- `APP_DEBUG`: Whether the app is in debug mode or not
#### Database settings
To configure the database connection, you have to set the `DB_*` variables in .env file with the following values:
- `DB_CONNECTION`: The database connection driver (mysql, pgsql, etc.)
- `DB_HOST`: The database host
- `DB_PORT`: The database port
- `DB_DATABASE`: The database name (will be created if it doesn't exist)
- `DB_USERNAME`: The database username
- `DB_PASSWORD`: The database password
You'll also need the appropriate PHP extension for the database connection driver (e.g. `ext-mysql` for MySQL).

### Email settings
To test locally the email sending, you need to configure the email settings with Mailhog. To do this, you have to follow these steps:
1. Install [Mailhog](https://github.com/mailhog/MailHog)
2. Run Mailhog (should be running on port 8025)
3. You can now send emails to Mailhog and see them in the Mailhog UI (http://localhost:8025)

### Sign in with Google
To login to the app with Google, you'll need to get credentials. To get credentials, you have to follow these steps:
1. Go to the [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project
3. Go to the [Credentials page](https://console.cloud.google.com/apis/credentials)
4. Create a new OAuth client ID
5. Configure consent screen
   1. Select "External" User Type and create
   2. Enter the app's name, email for users' assistance and the developer's email
   3. Add ".../auth/userinfo.email", ".../auth/userinfo.profile" and "openid" scopes
   4. Add new test users
   5. Return to the "Credentials" section
6. Create new credentials and select "OAuth client ID"
7. Select the "Web application" type
8. Set the "Authorized redirect URIs" to `http://localhost:8000/auth/google/callback` (or the URL of your project) and create
9. Set the `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI` variables in .env file with the credentials got

## Database

To create the database, you will need to run the following command after configuring the database connection in
your `.env` file:

```bash
php artisan migrate
```

> This will create the database tables (detailed: runs the migrations in the `database/migrations` directory).

## Usage

Before running the project, you will need to build the assets and migrate the database (see above).

## Troubleshooting
### Image failed to upload
Check the `upload_max_filesize` and `post_max_size` variables in your php.ini file.
If they are too low (2MB by default), you'll need to increase them.

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
