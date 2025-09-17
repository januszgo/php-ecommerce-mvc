#!/bin/bash
# Skrypt do kopiowania wszystkich plików do htdocs XAMPP

sudo chmod -R 777 ../php-ecommerce/
rsync -av --delete ../php-ecommerce/ /opt/lampp/htdocs/
