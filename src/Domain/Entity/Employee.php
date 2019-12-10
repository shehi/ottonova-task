<?php

namespace App\Domain\Entity;

class Employee
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var ?string
     */
    protected $name;

    /**
     * @var ?\DateTimeInterface
     */
    protected $birthdate;

    /**
     * @var ?\DateTimeInterface
     */
    protected $contractStartedAt;

    /**
     * @var ?int
     */
    protected $contractVacationDaysOvverride;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getContractStartedAt(): \DateTimeInterface
    {
        return $this->contractStartedAt;
    }

    public function setContractStartedAt(\DateTimeInterface $contractStartedAt): self
    {
        $this->contractStartedAt = $contractStartedAt;

        return $this;
    }

    public function getContractVacationDaysOvverride(): ?int
    {
        return $this->contractVacationDaysOvverride;
    }

    public function setContractVacationDaysOvverride(int $contractVacationDaysOvverride): self
    {
        $this->contractVacationDaysOvverride = $contractVacationDaysOvverride;

        return $this;
    }
}
