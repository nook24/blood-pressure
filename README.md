# Blood pressure - A CakePHP 4 App

This is a testing project to checkout the development status of CakePHP 4.
I used this small and simple application as a reference and playground while I am/was involved
into the migration process of [openITCOCKPIT](https://github.com/it-novum/openITCOCKPIT)
from CakePHP 2.x to CakePHP 4.x. 

This could also be used as an app skeleton for new applications.

And of course, you can also use it to document your blood pressure `¯\_(ツ)_/¯`

## Why the name?
Don't worry I'm healthy!
But due to the migration process my blood pressure raised from time to time^^


## Included components

- [CakePHP](https://github.com/cakephp/cakephp) 4.x-dev
    - [Authentication](https://book.cakephp.org/authentication/1.1/en/)
    - [Authorization](https://book.cakephp.org/authorization/1.1/en/request-authorization-middleware.html)
        - [ACL](https://github.com/it-novum/acl/tree/4.x-dev)
    - [CakePdf](https://github.com/FriendsOfCake/CakePdf)
- [AngularJS](https://angularjs.org/)
- [Chart.js](https://www.chartjs.org/)
- [Bootstrap 4](https://github.com/twbs/bootstrap)
    - [startbootstrap-sb-admin-2](https://github.com/BlackrockDigital/startbootstrap-sb-admin-2)

## Required system packages on Ubuntu 18.04
````
sudo apt-get install php-intl php-mbstring php-xml php-mysql mysql-server
````

## Development

### Requirements
 - PHP >= 7.2
 - [PHP Composer](https://getcomposer.org/)
 - [nodejs](https://nodejs.org/en/)

### Clone repository and install dependencies
```
git clone https://github.com/nook24/blood-pressure.git
cd blood-pressure/plugins/

git clone -b 4.x-dev https://github.com/it-novum/acl.git Acl
cd ../

composer install


cd webroot/
npm install
cd ../
```

### Create a mysql user and database
```SQL
CREATE USER 'bloodpressure'@'localhost' IDENTIFIED BY 'password';
CREATE DATABASE IF NOT EXISTS `bloodpressure` DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci;
GRANT ALL PRIVILEGES ON `bloodpressure`.* TO 'bloodpressure'@'localhost';
```

#### Set MySQL credentials in `config/app.php`
```PHP
[
    'Datasources' => [
        'default' => [
            'className' => Connection::class,
            'driver' => Mysql::class,
            'persistent' => false,
            'host' => 'localhost',
        
            'username' => 'bloodpressure',
            'password' => 'password',
            'database' => 'bloodpressure',
        ]
    ]
]
```

#### Set Security.cookieKey in `config/app.php`
```PHP
[
    'Security' => [
        'salt' => env('SECURITY_SALT', '__SALT__'),
        'cookieKey' => env('SECURITY_COOKIEKEY', '434cb56a-7808-4678-b649-db51e4d32629'),
    ],
]
```

#### Import database using migration
```
bin/cake migrations migrate -p Acl
bin/cake migrations migrate
```

### Sync Acos
```
bin/cake acl_extras aco_sync
```

### Create first user
```
bin/cake create_user
```

### Start development web server
````
bin/cake server

#or

bin/cake server --host 0.0.0.0
````

Navigate to `http://localhost:8765/`

#License
```
The MIT License

Copyright 2019 Daniel Ziegler

Permission is hereby granted, free of charge, to any person obtaining a
copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.
```

---

### Workaround for broken bake templates (due to cakephp 4 beta)
````
bin/cake bake model Measurements --no-fixture --no-test
````

