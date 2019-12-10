<?php

namespace App\Application\Service;

use App\Domain\Entity\Employee;

class ContractService
{
    private const MIN_VACATION_DAYS = 26;

    /**
     * @var \DateTimeInterface
     */
    private $startedAt;

    /**
     * @var int
     */
    private $vacationDaysOverride;

    /**
     * @var \DateTimeInterface
     */
    private $ownerBirthdate;

    public function __construct(Employee $employee)
    {
        $this->startedAt = $employee->getContractStartedAt();
        $this->vacationDaysOverride = $employee->getContractVacationDaysOvverride();
        $this->ownerBirthdate = $employee->getBirthdate();
    }

    public function calculateVacationDaysForGivenYear(int $year)
    {
        $annualVacationEntitlement = $this->getTotalVacationDays();
        if ($year > (int)$this->startedAt->format('Y')) {
            return $annualVacationEntitlement;
        }
        if ($year === (int)$this->startedAt->format('Y')) {
            $dayOfMonthContractStartedAt = (int)$this->startedAt->format('j');
            $monthOfYearContractStartedAt = (int)$this->startedAt->format('n');

            return $annualVacationEntitlement * (12 - $monthOfYearContractStartedAt + ($dayOfMonthContractStartedAt === 1 ? 1 : 0)) / 12;
        }

        return 0;
    }

    public function getTotalVacationDays(): int
    {
        $minVacationDays = $this->getMinVacationDays();
        $additionalVacationDays = $this->getAdditionalVacationDays();

        return $minVacationDays + $additionalVacationDays;
    }

    private function getMinVacationDays(): int
    {
        return $this->vacationDaysOverride ?? self::MIN_VACATION_DAYS;
    }

    private function getAdditionalVacationDays(): int
    {
        $now = new \DateTimeImmutable();
        $differenceInYears = (int)floor($now->diff($this->ownerBirthdate)->format('%y'));
        if ($differenceInYears < 30) {
            return 0;
        }

        return (int)floor(($differenceInYears - 30) / 5);
    }
}
