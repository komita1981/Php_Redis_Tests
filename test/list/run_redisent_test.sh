php /var/www/redistest/main.php -c redisent -i 1000 -m set_basic_lists
php /var/www/redistest/flushall.php
php /var/www/redistest/main.php -c redisent -i 1000 -m set_pipeline_lists
php /var/www/redistest/main.php -c redisent -i 1000 -m get_basic_lists
php /var/www/redistest/main.php -c redisent -i 1000 -m get_pipeline_lists
php /var/www/redistest/flushall.php