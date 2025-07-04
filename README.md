# VivePlus_Test
Este repositorio contiene el codigo Backend del proyecto de Gestion de cuentas para el test de Vive Plus


Se agrego dentro del repositorio el archivo .env con la finalidad de generar rapidamente la configuracion de claves AES, asi como la conexion a la Base de datos.

Para poder iniciar con las migraciones es necesario primero ejecutar el siguiente comando en el IDE SQL de preferencia -> create database viveplus_db;

Posterior a la creacion de la base de datos es necesario crear las tablas de base de datos mediante el siguiente comando -> php artisan migrate

El proyecto contiene un dato inicial (seed) para poder generar el token, para poder insertarlo en la BD es necesario ejecutar lo siguiente -> php artisan db:Seed

Finalmente se podra ejecutar el proyecto ejecutando -> php artisan serve 