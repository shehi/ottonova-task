## Taskie task

### Installation

```
composer install;
./bin/console.php vacation:calculate 2018;
```

I used a Docker container for development, so if you want that, go:
```
docker-compose up -d;
docker-compose exec php bash -lc "composer install";
docker-compose exec php bash -lc "./bin/console.php vacation:calculate 2018";
```

### Tests

* Without Docker: ```./vendor/bin/phpunit```
* With Docker: ```docker-compose exec php bash -lc "./vendor/bin/phpunit"```

### Implementation details

* Created fake ```Employee``` entity which maps data (the employees)
* Created fake ```EmployeeRepository``` to fetch the 5 employee records. It utilized ```DoctrineCommons::ArrayCollection``` to help working on our data collection (filtering etc), since we don't use actual RDBMS
* Created ```ContractService``` which is just a small wrapper, creating a "contract" from an Employee record and working with it. Some notes:
    * I didn't create separate ```Contract``` entity, thus separating ```Employee``` from contracts. It could be done, but I didn't see a need for it.
    * As a result of above point, ```ContractService``` ended up being a wrapper-handler for ```Employee``` data. It also is used by our command.
* Created ```CalculateVacationDaysCommand``` which, using ```ContractService```, fetches data via ```EmployeeRepository``` by filtering the applicable ones, based on the year provided; then calculates Vacation days for those records
* During the implementation, I assumed that contracts starting on 15th of a month disqualify that month for vacation eligibility.
