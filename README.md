# homework1
Homework #1 Loftschool.com

### Installation

```sh
$ git clone https://github.com/skaynetmen/homework1.git homework1
$ cd homework1
$ npm install
$ bower install
$ gulp build
$ cd dist
```
Copy dist on your web-server

### Backend
php >=5.4
php-fpm
nginx
mysql

```sh
$ compsoer install
$ cd config
$ mv database.ini.sample database.ini
$ mv recapthca.ini.sample recapthca.ini
$ mv smtp.ini.sample smtp.ini
```

####Nginx

```sh
location / {
	try_files $uri $uri/ /index.php?$query_string;
}
```