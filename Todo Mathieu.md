27/02/2022

Created branch 'Auth'
Installed Security Bundle "composer require symfony/security-bundle"

Used 'php bin/console make:user' to make user for auth

Problem = [ERROR] The file "src/Entity/User.php" can't be generated because it already exists.

I don't want to create a new User entity; i will try manually updating the exisiting User entity by c/c from Symphony docs ' https://symfony.com/doc/current/security.html'

Actually did not need to do anything, everything was already set up in the User Entity

Created Login controller for login page
set rederict for non authenticated users to login page









