## Play Book Sports

___

### Table of Contents

1. [Installation](#installation)
    1. [Clone](#clone)
    2. [Install Admin Panel & Client Application](#install)
2. [Run Application](#run-application)

___

### <a href="#installation">Installation</a>

#### <a href="#clone">Clone Repository</a>

```bash
#Via HTTP:     
https://github.com/michccano/sports-store
 
#or, Via SSH:  
git@github.com:michccano/sports-store.git
```

___

#### <a href="#install">Install Admin Panel & Client Application</a>

Two Templates are used for **_<u>Play Book Sports</u>_**. One for Client Side, another for admin panel.  
For client side  **Customized** template is used   
And, for admin panel we used **AdminLTE**

1. Install dependencies
   ```bash
   # 1. update and/or install php packages based on your system
   composer update
   # or just try to install
   composer install
   ```
3. Create & Update `.env` file
    1. ``` copy .env.example .env ```
    2. Update application name
    3. Generate app key `php artisan key:generate`
    3. Create database for this application and update database connection section
    4. Update mail sending credentials.
    5. Update Authorize.net credentials
        ``` 
       ANET_API_LOGIN_ID=
       ANET_TRANSACTION_KEY=
       ANET_PUBLIC_CLIENT_KEY=
        ```


4. Create Tables and Seed with data
   ```bash
   php artisan migrate --seed
   ```
5. Generate & Publish JWT Secret Key
   ```bash
   php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
   php artisan jwt:secret
   ```

___

### <a href="#run-application">Run Application</a>

   ```bash
   php artisan serve
   ```
