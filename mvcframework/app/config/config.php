<?php
/* fuctions in onrder to not have to change or add the URL every evry time */


//change dinamic,database params
define('DB_HOST', 'localhost'); //DB host
define('DB_USER', 'root'); // DB root
define('DB_PASS', ''); // DB pass
define('DB_NAME', 'mvcframework'); // DB Name

//APPROOT
define('APPROOT', dirname(dirname(__FILE__)));

//urlroot (dynamic links)
define('URLROOT', 'http://localhost/mvcframework');


//sitename
define('SITENAME', 'Study community');
