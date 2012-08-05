php /var/www/redistest/main.php -c redisserver -i 15000 -m set_basic_hashes
php /var/www/redistest/flushall.php
php /var/www/redistest/main.php -c redisserver -i 15000 -m set_pipeline_hashes
php /var/www/redistest/main.php -c redisserver -i 15000 -m get_basic_hashes
php /var/www/redistest/main.php -c redisserver -i 15000 -m get_pipeline_hashes
php /var/www/redistest/flushall.php