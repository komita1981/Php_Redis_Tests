php /var/www/redistest/main.php -c rediska -i 1000 -m set_basic_sortedsets
php /var/www/redistest/flushall.php
php /var/www/redistest/main.php -c rediska -i 1000 -m set_pipeline_sortedsets
php /var/www/redistest/main.php -c rediska -i 1000 -m get_basic_sortedsets
php /var/www/redistest/main.php -c rediska -i 1000 -m get_pipeline_sortedsets
php /var/www/redistest/flushall.php