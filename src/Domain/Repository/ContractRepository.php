<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Contract;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ContractRepository
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $store;

    public function __construct()
    {
        $this->store = new ArrayCollection();
        $this->store->add(
            (new Contract())
                ->setId(1)
                ->setEmployeeId(1)
                ->setCreatedAt(new DateTimeImmutable('2001-01-01'))
        );
        $this->store->add(
            (new Contract())
                ->setId(2)
                ->setEmployeeId(2)
                ->setCreatedAt(new DateTimeImmutable('2001-01-15'))
        );
        $this->store->add(
            (new Contract(27))
                ->setId(3)
                ->setEmployeeId(3)
                ->setCreatedAt(new DateTimeImmutable('2016-05-15'))
        );
        $this->store->add(
            (new Contract())
                ->setId(4)
                ->setEmployeeId(4)
                ->setCreatedAt(new DateTimeImmutable('2018-01-15'))
        );
        $this->store->add(
            (new Contract())
                ->setId(5)
                ->setEmployeeId(5)
                ->setCreatedAt(new DateTimeImmutable('2017-12-01'))
        );
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|Contract[]
     */
    public function getStore(): Collection
    {
        return $this->store;
    }

    public function findById(int $id): Contract
    {
        return $this->getStore()->filter(static function (Contract $c) use ($id) {
            return $c->getId() === $id;
        })->first();
    }
}
