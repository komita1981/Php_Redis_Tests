php /var/www/redistest/main.php -c redisserver -i 1000 -m set_basic_sets
php /var/www/redistest/flushall.php
php /var/www/redistest/main.php -c redisserver -i 1000 -m set_pipeline_sets
php /var/www/redistest/main.php -c redisserver -i 1000 -m get_basic_sets
php /var/www/redistest/main.php -c redisserver -i 1000 -m get_pipeline_sets
php /var/www/redistest/flushall.php