rada.valch.name
===============
for Lena

===============
vim /etc/crontab 

0 *	* * *	root	/usr/bin/php /var/www/rada.valch.name/cronrada.php

or

0 10	* * *	root	/usr/bin/php /var/www/rada.valch.name/cronrada.php

===============
mysqlcommands:

CREATE DATABASE rada CHARACTER SET utf8 COLLATE utf8_general_ci;
use rada;
CREATE TABLE zakoni (id MEDIUMINT NOT NULL AUTO_INCREMENT, url VARCHAR (255) NOT NULL, date DATE, state TINYINT, PRIMARY KEY (id));
