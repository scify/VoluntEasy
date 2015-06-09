# Volunteasy

## Starting the project

For installing Laravel, please refer to [Official Laravel installation guide](http://laravel.com/docs/5.0).

After cloning the project with a simple `git clone https://github.com/scify/VoluntEasy.git`, type `cd VoluntEasy/VoluntEasy && composer install` to install all dependencies.

*database instructions placeholder*

Initialize the database with `php artisan migrate` and test the installation with `php artisan serve` and hit `localhost:8000/auth/register` at your browser of choice.

After running migrations, it's time to create an initial user. Edit the file with `$EDITOR VoluntEasy/VoluntEasy/database/seeds/UserTableSeeder.php` and fill the appropriate fields (name, email, password, password, addr, tel). Going back to VoluntEasy/VoluntEasy, you may seed the database with `php artisan db:seed`. You can verify the created user with:

```
% psql -d <database_name>
<database_name>=> select * from users;
 id |  name   |        email        |                           password                           | level |              addr              |    tel     |                        remember_token                        |     created_at      |     updated_at
----+---------+---------------------+--------------------------------------------------------------+-------+--------------------------------+------------+--------------------------------------------------------------+---------------------+---------------------
  1 | <name>  | email@example.com   | <hashed password>                                            |       | <user address>                 | <user tel> |                                                              | 2015-06-09 07:20:51 | 2015-06-09 07:20:51
```

Verify login credentials by navigating at http://localhost/auth/login
