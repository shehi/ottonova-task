<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Employee;
use Doctrine\Common\Collections\ArrayCollection;

class EmployeeRepository
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $store;

    public function __construct()
    {
        $this->store = new ArrayCollection();
        $this->store->add(
            (new Employee())
                ->setId(1)
                ->setName('Hans Muller')
                ->setBirthdate(new \DateTimeImmutable('1950-12-30'))
                ->setContractStartedAt(new \DateTimeImmutable('2001-01-01'))
        );
        $this->store->add(
            (new Employee())
                ->setId(2)
                ->setName('Angelika Fringe')
                ->setBirthdate(new \DateTimeImmutable('1966-06-09'))
                ->setContractStartedAt(new \DateTimeImmutable('2001-01-15'))
        );
        $this->store->add(
            (new Employee())
                ->setId(3)
                ->setName('Peter Klever')
                ->setBirthdate(new \DateTimeImmutable('1991-07-12'))
                ->setContractStartedAt(new \DateTimeImmutable('2016-05-15'))
                ->setContractVacationDaysOvverride(27)
        );
        $this->store->add(
            (new Employee())
                ->setId(4)
                ->setName('Marina Helter')
                ->setBirthdate(new \DateTimeImmutable('1970-01-26'))
                ->setContractStartedAt(new \DateTimeImmutable('2018-01-15'))
        );
        $this->store->add(
            (new Employee())
                ->setId(5)
                ->setName('Sepp Meier')
                ->setBirthdate(new \DateTimeImmutable('1980-05-23'))
                ->setContractStartedAt(new \DateTimeImmutable('2017-12-01'))
        );
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStore(): \Doctrine\Common\Collections\Collection
    {
        return $this->store;
    }
}
