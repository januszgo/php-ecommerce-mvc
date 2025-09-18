#!/bin/bash
# Skrypt do kopiowania wszystkich plików do htdocs XAMPP

sudo chmod -R 777 .
rsync -av --delete . /opt/lampp/htdocs/
