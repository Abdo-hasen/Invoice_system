<!--

 php artisan ser
//  current server : [http://127.0.0.1:8000].



// how to make controller :
 php artisan make:controller ControllerName
 (caps in name convention)


//make migrate file :
php artisan make:migration create_categories_table

//migration of file into db and create database :
php artisan migrate



php artisan make:model Product -m
 ده shortcut بيعمل
migration and model

 php artisan make:model Chef --all
make all files u need to table ex : Controller - Request - Seeder- Migration - Factory - Model




 php artisan make:model Chef -mfsc

    make : Controller - Seeder - Migration - Factory - Model




بتمسح كل tables
وبت creat التابلز من جديد
ثم بتعمل seed للداتا فيهم      *




     *
     *بتعمل seed ل database seeder

    php artisan db:seed


   //make custom request
    - php artisan make:request product/UpdateProductRequest

    //publish lang folder[can override message appear in laravel like in validations]
    php artisan lang:publish


//custom middleware
php artisan make:middleware IsAdmin



// make resource controller
php artisan make:controller test/TestController --resource

// see u route especially resource route
php artisan route:list


// invoke controller
 php artisan make:controller UserProfileController -i


// rollback last migrate [الفايل لا يتمسح]
php artisan migrate:rollback


// rollback 5 make:migrate[بغض النظر عن كام جدول]
php artisan migrate:rollback --step=5 

//rollback all
php artisan migrate:reset


// drop all + migrate[delete all data]
php artisan migrate:fresh --seed
php artisan migrate:fresh = php artisan mi:f


// rollback all + migrate[delete all data]
php artisan migrate:refresh
php artisan migrate:refresh --seed
php artisan migrate:refresh --step=5


//add colum in laravel with migration  

php artisan make:migration add_user_id_to_posts

//make notification
php artisan make:notification InvoicePaid

//regenerate the Laravel autoload - problems with new packages -  If you change a class name  - if u have a problem after review code

composer dump-autoload

//any changes in .env -  after you make changes to your configuration files - if u have a problem after review code -
The cache can be used to store things like configuration data, compiled views, and user sessions. Clearing the cache can help to improve the performance of your Laravel application by forcing Laravel to re-load the data from the database or filesystem.

php artisan cache:clear



// update your dependencies, ignoring any platform requirements like: php version - operating system , your requirements with update package - must sure u use write version of laravel and php AND composer and test application after that
composer update --ignore-platform-reqs
composer install --ignore-platform-reqs

//export excel
php artisan make:export InvoicesExport --model=Invoice

//make custom seeder
php artisan make:seeder CreateOwnerUserSeeder

//run custom seeder
php artisan db:seed --class=PermissionTableSeeder

//make notification table
php artisan notifications:table

-->
