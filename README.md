# TEST merqueo

Este test está desarrollado en PHP usando el framework [LARAVEL](https://laravel.com).

Para este desarrollo se utilizó el patron de diseño MVC (Modelo Vista Controlador).
Se uso el controlador [CashRegisterController.php](https://github.com/camiloruizvidal/merqueo_test/blob/main/app/Http/Controllers/CashRegisterController.php) para las peticiones http. Se crearon los modelos:
1) [TblBillsMoney](https://github.com/camiloruizvidal/merqueo_test/blob/main/app/Models/TblBillsMoney.php)
1) [TblMovementBox](https://github.com/camiloruizvidal/merqueo_test/blob/main/app/Models/TblMovementBox.php)
1) [TblMovementBoxDetail](https://github.com/camiloruizvidal/merqueo_test/blob/main/app/Models/TblMovementBoxDetail.php)

La documentación del API se encuentra en el archivo [README API.md](https://github.com/camiloruizvidal/merqueo_test/blob/main/README%20API.md)
que está en la raiz del proyecto.

## Iniciar proyecto

1) Se requiere montar una base de datos, se utilizó mysql para la prueba.
1) Se configura la conexión a la base de datos en el archivo ``` .env ```.
Existe una copia de prueba llamada ```.env.example```.
1) A continuación se ejecuta el siguiente comando para generar la llave de
encriptacion. ```php artinsa key:generate```.
1) Se requiere generar las tablas, mediante el sistemas de migraciones de laravel
se debe ejecutar el siguiente comando ``` php artisan migrate ```.
1) En este momento ya tenemos nuestro sistema montado. Ahora corremos nuestro servidor
con Laravel utilizando el comando ```php artisan serve```

## Conectar con el API

Para poder realizar la consulta al API por favor lea la siguiente documentación [README API.md](https://github.com/camiloruizvidal/merqueo_test/blob/main/README%20API.md)
