# Midas Fountain of Knowledge (MFoK)

Functions:
* CoB Logger
* Crystalized Experience
* Tips and Tricks
* Queries and Answers

## Setup
### Prerequisites
* XAMPP
* Composer
* Laravel

### Installing XAMMP
1. Download XAMPP from [here](https://www.apachefriends.org/download.html).
2. Run the installer and install on desired directory. Just be sure to remember where it is installed.

### Installing Composer
1. Download Composer from [here](https://getcomposer.org/download/).
2. Run the installer.
3. When prompted for a PHP command line interface, select the php.exe on `<XAMMP installation folder>/php/php.exe`.
4. To check if Composer is properly installed, open a command prompt window and enter `composer -v`.

### Installing Laravel
1. Download the Laravel installer using Composer by entering `composer global require laravel/installer` on a command prompt window.

### Setting up the repository
1. Clone the repository from Github.
2. Open a command prompt window on the code's root directory.
3. Install the Laravel dependencies by entering `composer install` on the command prompt.
4. Copy the .env.example file and rename the copy into .env. This could be done manually or by entering `copy .env.example .env` on the command prompt.
5. Generate the application key needed by Laravel by entering `php artisan key:generate` on the command prompt.
6. Enter `php artisan serve` to launch the Laravel server.
7. Go to the address shown after `Starting Laravel development server:` on the command prompt to check if Laravel is working well.

### Setting up the database for CoB Logger Component
1. Run XAMPP.
2. Start the Apachec and MySQL module.
3. Go to the MySQL admin panel by clicking the admin button on the MySQL row on XAMPP or by going to `http://localhost:<apache http port>/phpmyadmin/`.
4. Click the Databases tab.
5. On the Create Database input field, type `mfok_cob`. This would be the database used by the MFoK CoB Logger component.
6. Click Create button to finish the database creation.
7. Open the .env file on the code's root folder using a text editor.
8. Find the line `DB_DATABASE` and set it to mfok_cob.
9. If you have a different MySQL user and password, set it now.
10. Find `DB_PORT` and check if it is the same as the port used by MySQL on XAMPP.
11. Open a command prompt window on the code's root directory.
12. Enter `php artisan migrate` to run all of the migrations set by the project. This would create several tabled on the mfok_cob database.
13. Enter `php artisan db:seed` to seed the tables with the initial values set by the project. This would create the default admin records on the database.
14. Go to `http://localhost:<apache http port>/phpmyadmin/` and check the mfok_cob database if the tables and records have been added.

### Setting up Vue dependencies
1. Open command prompt on the project root directory.
2. Enter the command `npm install`.
3. While running the server either using a Virtual host or an artisan server, remember to run `npm run watch` on the project's root directory in order for the code changes to apply.
