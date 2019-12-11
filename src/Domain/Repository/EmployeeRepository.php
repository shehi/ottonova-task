<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Employee;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
                ->setBirthdate(new DateTimeImmutable('1950-12-30'))
        );
        $this->store->add(
            (new Employee())
                ->setId(2)
                ->setName('Angelika Fringe')
                ->setBirthdate(new DateTimeImmutable('1966-06-09'))
        );
        $this->store->add(
            (new Employee())
                ->setId(3)
                ->setName('Peter Klever')
                ->setBirthdate(new DateTimeImmutable('1991-07-12'))
        );
        $this->store->add(
            (new Employee())
                ->setId(4)
                ->setName('Marina Helter')
                ->setBirthdate(new DateTimeImmutable('1970-01-26'))
        );
        $this->store->add(
            (new Employee())
                ->setId(5)
                ->setName('Sepp Meier')
                ->setBirthdate(new DateTimeImmutable('1980-05-23'))
        );
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|Employee[]
     */
    public function getStore(): Collection
    {
        return $this->store;
    }

    public function findById(int $id): Employee
    {
        return $this->getStore()->filter(static function (Employee $e) use ($id) {
            return $e->getId() === $id;
        })->first();
    }
}
