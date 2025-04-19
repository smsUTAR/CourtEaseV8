Laravel Version 8 is in use in this project

As of 16 April 2025,
1. Created a new database "courtease". (make sure u change the DB_DATABASE in .env file)

2. Created a new BookingController file for controlling the booking process of the system.

3. Created 2 new routes in routes/web.php.

4. Created 2 new views (payment.blade.php and booking-confirmation.blade.php)

5. Created 2 new Models (Court and Booking)

6. Created 2 new database migrations (make sure u migrate both by specifying the paths)


# jm done (user login, user register, admin login, admin register, account panel)

1. add controller app/http/controllers/auth
2. add app/mail
3. modify user models app/models/user
4. add validation app/traits
5. add user data to database/migration
6. add icon to public/icons
7. add profile pic to public/images
8. add view account
9. add view auth
10. add header recources/views/components
11. add route
12. update env session, adminSecretCode, eMail

## jm env setup(to add for admin register and user forgot pwd)
ADMIN_SECRET_CODE=adminadmin123

SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=false
SESSION_DOMAIN=null
SESSION_COOKIE=courtease_session


## to send email for user forgot pwd
1. signup acc in https://login.brevo.com/
2. top right acc button (choose senders,dmain & dedicated ips)
3. add sender
4. replace in env for (mail from address)
5. top right acc button (choose smtp and api)
6. replace in env for mailhost(smtp server), mailport(port), mailusername(login), mailpassword(masterpassword), mailencrytion(tls)

