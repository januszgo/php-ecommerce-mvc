# Skrypt PowerShell do kopiowania wszystkich plików do htdocs XAMPP

$source = "..\php-ecommerce\"
$destination = "C:\xampp\htdocs\"

# Kopiowanie plików z nadpisaniem istniejących i usuwaniem nieistniejących
# (odpowiednik rsync --delete)
robocopy $source $destination /MIR

# Ustawienie pełnych uprawnień (odpowiednik chmod 777)
icacls $destination /grant "*S-1-1-0:(OI)(CI)F" /T
