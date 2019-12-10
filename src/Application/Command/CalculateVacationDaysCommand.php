<?php

namespace App\Application\Command;

use App\Application\Service\ContractService;
use App\Domain\Entity\Employee;
use App\Domain\Repository\EmployeeRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateVacationDaysCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('vacation:calculate')
            ->setDescription('Calculates the number of vacations.')
            ->addArgument('year', InputArgument::REQUIRED, 'Year of interest.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = (int)$input->getArgument('year');
        $currentYear = (int)(new \DateTimeImmutable())->format('Y');
        if ($year < 1900 && $year > $currentYear) {
            $output->writeln('Year needs to be between 1900 and ' . $currentYear);

            return 1;
        }

        $output->writeln([
                'Employees and Vacation Entitlements for year ' . $year,
                '========================================================'
            ]
        );

        $dataStore = new EmployeeRepository();
        /** @var Employee[] $data */
        $data = $dataStore->getStore()->filter(static function (Employee $e) use ($year) {
            return (int)$e->getContractStartedAt()->format('Y') <= $year;
        });

        foreach ($data as $employee) {
            $contract = new ContractService($employee);
            $vacationDays = $contract->calculateVacationDaysForGivenYear($year);
            $yearlyEntitlement = $contract->getTotalVacationDays();
            $output->writeln(sprintf("%s\t\t %.2f days (of %.2f days p.a.)", $employee->getName(), $vacationDays, $yearlyEntitlement));
        }

        return 0;
    }
}
