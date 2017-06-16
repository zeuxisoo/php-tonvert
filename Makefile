all:
	@echo ""
	@echo "Commands      : Description"
	@echo "------------- : -------------"
	@echo "make composer : Get composer"
	@echo "make autoload : Dump autoload classes"
	@echo "make test     : Do test case"
	@echo ""

composer:
	@curl https://getcomposer.org/composer.phar -o composer.phar

autoload:
	@php composer.phar dumpautoload

test:
	@php ./vendor/bin/phpunit
