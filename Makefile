install:
	composer install
validate:
	composer validate
lint:
	composer run-script phpcs -- --standard=PSR12 bin tests
test:
	composer exec --verbose phpunit tests
