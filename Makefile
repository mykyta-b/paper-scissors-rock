###################################
test:
	./vendor/bin/phpunit -c ./phpunit.xml.dist --coverage-html 'reports/clover_html' --bootstrap  vendor/autoload.php tests
install:
	composer install
play:
	php game.php
