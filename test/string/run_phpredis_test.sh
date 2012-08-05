php /var/www/redistest/main.php -c phpredis -i 20000 -m set_basic_strings
php /var/www/redistest/flushall.php
php /var/www/redistest/main.php -c phpredis -i 20000 -m set_pipeline_strings
php /var/www/redistest/main.php -c phpredis -i 20000 -m get_basic_strings
php /var/www/redistest/main.php -c phpredis -i 20000 -m get_pipeline_strings
php /var/www/redistest/flushall.php