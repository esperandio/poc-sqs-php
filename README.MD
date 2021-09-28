## Run phpcs
```
docker exec php ./vendor/bin/phpcs --standard=PSR12 index.php
docker exec php ./vendor/bin/phpcbf --standard=PSR12 index.php
```

## Run phpstan
```
docker exec php ./vendor/bin/phpstan analyse -l 8 index.php