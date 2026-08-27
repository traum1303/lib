<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

#[Signature('app:setup')]
#[Description('Command description')]
class SetupCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $env = base_path('.env');

        if (!File::exists($env)) {
            File::copy(
                base_path('.env.example'),
                $env
            );
        }
        $this->call('migrate');
        $this->call('storage:link');
        $this->call('db:seed');
        $process1 = new Process([
            'npm',
            'install',
        ]);

        $process1->setWorkingDirectory(base_path());

        $process1->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        $this->info($process1->getExitCode());

        $process2 = new Process([
            'npm',
            'run',
            'build',
        ]);

        $process2->setWorkingDirectory(base_path());

        $process2->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        return $process2->getExitCode();
    }
}
