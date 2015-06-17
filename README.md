# Volunteasy

### Starting the project

For installing Laravel, please refer to [Official Laravel installation
guide](http://laravel.com/docs/5.0).

After cloning the project with a simple `git clone
https://github.com/scify/VoluntEasy.git`, type `cd VoluntEasy/VoluntEasy &&
composer install` to install all dependencies.

### Installing dependencies (assuming nginx as web server):

For Linux (Debian based):

`% sudo aptitude install nginx php5-fpm php5-mcrypt mcrypt`

For OpenBSD:

`% sudo pkg_add nginx php-fpm php-mcrypt mcrypt`

### Settings:

For Linux:

Disable cgi.fix_pathinfo at /etc/php5/fpm/php.ini: `cgi.fix_pathinfo=0`

`% sudo php5enmod mcrypt && sudo service php5-fpm restart`

For OpenBSD:

Disable cgi.fix_pathinfo at /etc/php-5.5.ini: `cgi.fix_pathinfo=0`

`% sudo php5enmod mcrypt && sudo /etc/rc.d/php_fpm restart`

Nginx server block:

```
server {
    listen 80 default_server;
    listen [::]:80 default_server ipv6only=on;

    root /var/www/laravel/public;
    index index.php index.html index.htm;

    server_name server_domain_or_IP;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

For Linux:

`% sudo service nginx restart && sudo chmod -R 755 path/to/project/storage`

For OpenBSD:

`% sudo /etc/rc.d/nginx restart && sudo chmod -R 755 path/to/project/storage`

And finally, set the group appropriately:

`% sudo chown -R www-data storage`

*database instructions placeholder*

Initialize the database with `php artisan migrate` and test the installation
with `php artisan serve` and hit `localhost:8000/auth/register` at your browser
of choice.

After running migrations, it's time to create an initial user.

Navigate at the root directory and run `./config-user.pl`. The script asks for initial user info. After filling everything, you will be asked if the info is correct. If not, just press `n` and it will run once more. Upon successful completion, the database seed file will be generated. It's time to seed the database with `php artisan db:seed --class=UserTableSeeder`. You can verify the created user with:


```
% psql -d <database_name>
<database_name>=> select * from users;
 id |  name   |        email      |      password     | level |     addr       |    tel     |
----+---------+-------------------+-------------------+-------+----------------+------------+
  1 | <name>  | email@example.com | <hashed password> |       | <user address> | <user tel> |

 remember_token |     created_at      |     updated_at
----------------+---------------------+---------------------
                | 2015-06-09 07:20:51 | 2015-06-09 07:20:51
```

Verify login credentials by navigating at http://localhost/auth/login

### Mail setup

Manual intervention required in this. You'll have to edit
VoluntEasy/VoluntEasy/config/mail.php and set the global "From" Address from:

```
'from' => ['address' => null, 'name' => null],
```

to

```
'from' => ['address' => 'myaddress@example.com', 'name' => 'My Name'],
```

Configure your .env file appropriately:

```
MAIL_DRIVER=smtp
MAIL_HOST=your.address
MAIL_PORT=port_num
MAIL_USERNAME=username
MAIL_PASSWORD=password
```

Example for relay mail through Gmail:

```
# inside config/mail.php
'from' => ['address' => 'myname@gmail.com', 'name' => 'My Name'],
```

```
# inside .env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=myname@gmail.com
MAIL_PASSWORD=mypass
```
