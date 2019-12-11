<?php

namespace App\Application\Command;

use App\Application\Service\ContractService;
use App\Domain\Entity\Contract;
use App\Domain\Repository\ContractRepository;
use App\Domain\Repository\EmployeeRepository;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateVacationDaysCommand extends Command
{
    /**
     * @var \App\Domain\Repository\EmployeeRepository
     */
    private $employeeRepository;

    public function __construct(string $name = null)
    {
        $this->employeeRepository = new EmployeeRepository();
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('vacation:calculate')
            ->setDescription('Calculates the number of vacations.')
            ->addArgument('year', InputArgument::REQUIRED, 'Year of interest.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = (int)$input->getArgument('year');
        $currentYear = (int)(new DateTimeImmutable())->format('Y');
        if ($year < 1900 && $year > $currentYear) {
            $output->writeln('Year needs to be between 1900 and ' . $currentYear);

            return 1;
        }

        $output->writeln([
                'Employees and Vacation Entitlements for year ' . $year,
                '========================================================'
            ]
        );

        $contractDataStore = new ContractRepository();
        /** @var Contract[] $contracts */
        $contracts = $contractDataStore->getStore()->filter(static function (Contract $c) use ($year) {
            return (int)$c->getCreatedAt()->format('Y') <= $year;
        });
        foreach ($contracts as &$contract) {
            $contractService = new ContractService($contract, $this->employeeRepository); // DependencyInjection emulated for 2nd argument here.
            $vacationDaysForGivenYear = $contractService($year);
            $vacationDaysYearly = $contractService->getTotalVacationDays();
            $employee = $this->employeeRepository->findById($contract->getEmployeeId());
            $output->writeln(sprintf("%s\t\t %.2f days (of %.2f days p.a.)", $employee->getName(), $vacationDaysForGivenYear, $vacationDaysYearly));
        }
        unset($contract);

        return 0;
    }
}
