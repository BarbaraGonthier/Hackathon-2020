# Hackathon 2020

## Description

This repository is a Wild Code School Hackathon project made on November 19-20, 2020. The structure is based on a simple PHP MVC structure from scratch.

It uses some vendors/libraries such as Twig and Grumphp.

Back in Spartans time, we offer this training application allowing you to search for exercices according to muscles you want to train, add exercices to your favorites, visit the equipment shop to request any missing one to your commander. It also includes an administration interface to handle the stocks equipment and the received orders (CRUD).


### Check on Travis

1. Go on [https://travis-ci.com](https://travis-ci.com).
2. Sign up if you don't have account,
3. Look for your project in search bar on the left,
4. As soon as your repository have a `.travis.yml` in root folder, Travis should detect it and run test.
5. Configure Travis as described in the screenshot below, this is needed to avoid performance issues.

> You can watch this screenshot to see minimum mandatory configuration : ![basic config](http://images.innoveduc.fr/symfony4/travis-config.png)


## Steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create a database and add tables according to this screenshot : 

![DTB screenshot](https://github.com/BarbaraGonthier/Hackathon-2020/blob/master/public/assets/images/DTB_hackathon.png)

4. Create *config/db.php* from *config/db.php.dist* file and add your DB parameters. Don't delete the *.dist* file, it must be kept.
```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PWD', 'your_db_password');
```
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser.
7. From this starter kit, create your own web application.
