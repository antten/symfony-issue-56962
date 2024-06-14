### How to reproduce?

I create a test to reproduce this unexpected behavior. Without the patch, the test fails.

Run next command to execute it:

```shell 
php bin/phpunit
```

Or, if you use Docker :

```shell
docker compose run --rm php-apache php bin/phpunit
```
