<?php

namespace App\Application\Service;

use App\Domain\Entity\Contract;
use App\Domain\Repository\EmployeeRepository;
use DateTimeImmutable;

class ContractService
{
    /**
     * @var \App\Domain\Entity\Contract
     */
    private $contract;

    /**
     * @var \App\Domain\Repository\EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var int
     */
    public $totalVacationDays;

    public function __construct(Contract $contract, EmployeeRepository $employeeRepository)
    {
        $this->contract = $contract;
        $this->employeeRepository = $employeeRepository;
        $this->totalVacationDays = $this->contract->getMinVacationDays() + $this->calculateVacationBonusesBasedOnAge();
    }

    public function __invoke(int $year)
    {
        if ($year > (int)$this->contract->getCreatedAt()->format('Y')) {
            return $this->totalVacationDays;
        }
        if ($year === (int)$this->contract->getCreatedAt()->format('Y')) {
            $dayOfMonthContractStartedAt = (int)$this->contract->getCreatedAt()->format('j');
            $monthOfYearContractStartedAt = (int)$this->contract->getCreatedAt()->format('n');

            return $this->totalVacationDays * (
                    12 - $monthOfYearContractStartedAt + ($dayOfMonthContractStartedAt === 1 ? 1 : 0)
                ) / 12;
        }

        return 0;
    }

    private function calculateVacationBonusesBasedOnAge(): int
    {
        $now = new DateTimeImmutable();
        $employee = $this->employeeRepository->findById($this->contract->getEmployeeId());
        $differenceInYears = (int)floor($now->diff($employee->getBirthdate())->format('%y'));
        if ($differenceInYears < 30) {
            return 0;
        }

        return (int)floor(($differenceInYears - 30) / 5);
    }

    public function getTotalVacationDays(): int
    {
        return $this->totalVacationDays;
    }
}
