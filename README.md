## Start the app

```shell
./vendor/bin/sail up
```

### Migrate and seed the DB (just once)
```shell
./vendor/bin/sail artisan migrate --seed
```

## Use it

```http request
http://localhost/api/convert/13/eur/usd/
```

## Test it
```shell
./vendor/bin/sail test
```
