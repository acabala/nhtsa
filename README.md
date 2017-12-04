The purpose of this project is to provide customized proxy API to NHTSA NCAP 5 Star Safety Ratings API


## Project setup

install composer packages:
```
composer install
```

run build-in server on port 8080
```
./bin/console server:start 8080
```


run phpspec tests
```
./vendor/bin/phpspec run
```

## Available endpoints

```
GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>
GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>?withRating=true
```

example:
```
GET http://localhost:8080/vehicles/2015/Audi/A3
```



```
POST http://localhost:8080/vehicles
```
with data:
```
{
    "modelYear": 2015,
    "manufacturer": "Audi",
    "model": "A3"
}
```
