Celestic v2
================================

Web Project Manager API developed with Yii2.0


DIRECTORY STRUCTURE
-------------------

      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      web/                contains the entry script and Web resources

REQUIREMENTS
------------

PHP 5.4.0
MySQL 5.2
Apache 2.0

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=celestic',
    'username' => 'root',
    'password' => 'password',
    'charset' => 'utf8',
];
```

Also check and edit the other files in the `config/` directory to customize your application.
