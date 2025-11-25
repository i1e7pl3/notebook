@echo off
echo Проверка установки PHP...
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo.
    echo ========================================
    echo PHP не установлен!
    echo ========================================
    echo.
    echo Пожалуйста, установите PHP одним из способов:
    echo.
    echo 1. Скачайте PHP с https://windows.php.net/download/
    echo    и добавьте в PATH
    echo.
    echo 2. Или установите XAMPP с https://www.apachefriends.org/
    echo    и скопируйте проект в C:\xampp\htdocs\
    echo.
    echo Подробнее см. README.md
    echo.
    pause
    exit /b 1
)

echo PHP найден!
echo.
echo Запуск веб-сервера...
echo.
echo Откройте в браузере: http://localhost:8000/index.php
echo.
echo Для остановки сервера нажмите Ctrl+C
echo.
php -S localhost:8000

