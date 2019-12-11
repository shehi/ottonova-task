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

* Created fake ```Employee``` entity which maps Employee data
* Created fake ```Contract``` entity which maps Contract data, linking them to ```Employee``` entities
* Created fake ```EmployeeRepository``` and ```ContractRepository``` to fetch the related records. They utilize ```DoctrineCommons::ArrayCollection``` to help working on our data collection (filtering etc), since we don't use actual RDBMS
* Created ```ContractService``` which is just a small wrapper, which processes the data to calculate vacation days for a given year.
* Created ```CalculateVacationDaysCommand``` which, after fetching Contract data from ```ContractRepository``` (filtering the applicable ones, based on the year provided), passes it to ```ContractService``` for needed calculations. 
* During the implementation, I assumed that contracts starting on 15th of a month disqualify that month for vacation eligibility.
* During the implementation, where you'd have DependencyInjection, I just emulated the situation by passing needed object for ease of use purposes. 
