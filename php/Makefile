all:
	@echo ""
	@echo "Commands      : Description"
	@echo "------------- : -------------"
	@echo "make composer : Get composer"
	@echo "make autoload : Dump autoload classes"
	@echo ""

composer:
	@curl https://getcomposer.org/composer.phar -o composer.phar

autoload:
	@php composer.phar dumpautoload
