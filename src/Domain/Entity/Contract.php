<?php

namespace App\Domain\Entity;

use DateTimeInterface;

class Contract
{
    private const MIN_VACATION_DAYS = 26;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $employeeId;

    /**
     * @var int
     */
    protected $minVacationDays = self::MIN_VACATION_DAYS;

    /**
     * @var ?\DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var bool
     */
    protected $isCustom = false;

    public function __construct(int $vacationDays = null)
    {
        if ($vacationDays !== null) {
            $this->setIsCustom(true);
            $this->setMinVacationDays($vacationDays);
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    public function setEmployeeId(int $employeeId): self
    {
        $this->employeeId = $employeeId;

        return $this;
    }

    public function getMinVacationDays(): int
    {
        return $this->minVacationDays;
    }

    public function setMinVacationDays(?int $minVacationDays): self
    {
        $this->minVacationDays = $minVacationDays;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isCustom(): bool
    {
        return $this->isCustom;
    }

    public function setIsCustom(bool $isCustom): self
    {
        $this->isCustom = $isCustom;

        return $this;
    }
}
