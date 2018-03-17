@echo OFF
:: in case DelayedExpansion is on and a path contains !
setlocal DISABLEDELAYEDEXPANSION
php -c D:\wanmp\php56n\php-composer.ini "%~dp0composer.phar" %*
