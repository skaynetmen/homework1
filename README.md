# homework1
Homework #1 Loftschool.com

### Requirements
- node.js
- bower
- php >=5.4
- GD module for php
- PDO mysql module for php
- composer
- mysql

### Installation

```sh
$ git clone https://github.com/skaynetmen/homework1.git homework1
$ cd homework1
$ npm install
$ bower install
$ gulp build
$ cd dist
```
Copy dist on your web-server, then:

```sh
$ composer install
$ cd config
$ mv database.ini.sample database.ini
$ mv recapthca.ini.sample recapthca.ini
$ mv smtp.ini.sample smtp.ini
```

Create database and load dump.sql (with demo content) or db.sql.

#### Apache 2

```sh
Options +FollowSymLinks
RewriteEngine On
RewriteRule ^(.*)$ index.php [NC,L]
```

#### Nginx

```sh
location / {
	try_files $uri $uri/ /index.php?$query_string;
}
```

License
----

MIT