<?php namespace App\Tests;

use App\Application\Command\CalculateVacationDaysCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CalculateVacationDaysCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $application = new Application();
        $application->add(new CalculateVacationDaysCommand());
        $command = $application->find('vacation:calculate');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'year' => '2018',
        ]);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString("Hans Muller\t\t 33.00 days (of 33.00 days p.a.)", $output);
        $this->assertStringContainsString("Angelika Fringe\t\t 30.00 days (of 30.00 days p.a.)", $output);
        $this->assertStringContainsString("Peter Klever\t\t 27.00 days (of 27.00 days p.a.)", $output);
        $this->assertStringContainsString("Marina Helter\t\t 26.58 days (of 29.00 days p.a.)", $output);
        $this->assertStringContainsString("Sepp Meier\t\t 27.00 days (of 27.00 days p.a.)", $output);

        $commandTester->execute([
            'year' => '2016',
        ]);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString("Hans Muller\t\t 33.00 days (of 33.00 days p.a.)", $output);
        $this->assertStringContainsString("Angelika Fringe\t\t 30.00 days (of 30.00 days p.a.)", $output);
        $this->assertStringContainsString("Peter Klever\t\t 15.75 days (of 27.00 days p.a.)", $output);
        $this->assertStringNotContainsString('Marina Helter', $output);
        $this->assertStringNotContainsString('Sepp Meier', $output);

        $commandTester->execute([
            'year' => '2001',
        ]);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString("Hans Muller\t\t 33.00 days (of 33.00 days p.a.)", $output);
        $this->assertStringContainsString("Angelika Fringe\t\t 27.50 days (of 30.00 days p.a.)", $output);
        $this->assertStringNotContainsString('Peter Klever', $output);
        $this->assertStringNotContainsString('Marina Helter', $output);
        $this->assertStringNotContainsString('Sepp Meier', $output);
    }
}
