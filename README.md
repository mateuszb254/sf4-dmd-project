# SF4-DMD-PROJECT

Application written for https://diamondmt2.org based on Symfony4 Framework.

The project is under development

![my image](./assets/_user/images/presentation/page.png#center)  

## Installation

* Clone the project 

```git clone https://github.com/mateuszb254/sf-4-dmd-portal```

* Install PHP dependencies

```
composer install
```

## Configuration

* Create the .env.local.php file

```composer dump-env demo```

* Configure your database url

``` 'DATABASE_URL' => mysql://username:password@host:port/db_name ```

* Create a database

```php bin/console doctrine:database:create```

* Execute a migration

```doctrine:migrations:migrate``` 

* Execute DataFixtures

```php bin/console doctrine:fixtures:load```

* Configure your mailer url (optional)

``` 'MAILER_URL' => 'smtp://localhost:25?encryption=&auth_mode='```

You can disable sending e-mails in ```config/swiftmailer.yml``` setting ```disable_delivery``` to true

* Configure your recaptcha url (v2 supported) (optional)

```
'RECAPTCHA_PUBLIC_KEY' => 'PUBLIC_KEY'
'RECAPTCHA_SECRET_KEY' => 'SECRET_KEY'
```

You can disable the recaptcha check in ``` config/app.yaml``` setting ```recaptcha.enbaled``` to false


## Front-end

* To re-generate the frontend assets (optional)

```
yarn install

yarn build
```


