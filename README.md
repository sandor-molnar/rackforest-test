# Rackforest test
Minimális PHP verzió: php 8.1  
## Futtatás
Elsőként másoljuk le a `config-example.php` fájlt és másoljuk az `src/config/` mappába mint `config.php`.  
Töltsük ki tartalmát a `mysql` csatlakozásunkal.  
A public mappában:
```bash
$ php -S
```
Vagy megfelelő vhost ami a public mappára mutat.
## Auth
A `rackforest-test.sql` a következő teszt felhasználót tartalmazza:
```
Email: test@test.hu
Password: test
```