## Pre-requisite
1. Type 'composer install' to install the vendor folder.

2. Create a new .env file, then copy the code from .env.example and paste it on the newly created .env file

3. Migrate all the tables from 'database/migrations' by performing 'php artisan migrate'.

4. Seed the CourtSeeder by typing 'php db:seed' in the command prompt.

5. Insert court images in 'storage/app/public' so that you are able to view the court image in the application.

6. Rename your images from 'court_1' to 'court_6'. You do not need to rename the images uploaded later by yourselves.

7. To let the picture show in the view, you need to run 'php artisan storage:link'.

## Instructions
1. To access the normal user's login page, type in 'localhost:8000/login'; to access the admin's login page, type in 'localhost:8000/admin/login'.
However, admins are still able to login from the normal user's login page.

2. When you want to reset your password, you have to look into 'storage/logs/laravel.log', and scroll down to find your verification code.

3. The secret code for registering an admin is 'adminadmin123'.

4. As an admin, when adding a new court, the image can be selected from any folder.
It will ultimately make another copy of the same image in the path 'storage/app/public'.


SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=false
SESSION_DOMAIN=null
SESSION_COOKIE=courtease_session


## to send email for user forgot password
1. signup acc in https://login.brevo.com/
2. top right acc button (choose senders,dmain & dedicated ips)
3. add sender
4. replace in env for (mail from address)
5. top right acc button (choose smtp and api)
6. replace in env for mailhost(smtp server), mailport(port), mailusername(login), mailpassword(masterpassword), mailencrytion(tls)


