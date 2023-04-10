<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class TestAppCommand extends Command
{
    protected $signature = 'test:app';

    protected $description = 'Command description';

    public function handle(): int
    {
        try {
            $this->info("Starting test\n");

            $this->info("\nDone\n");
            return 0;
        } catch (Exception $e) {
            $this->warn("\nError found");
            $this->error($e->getMessage());
            $this->newLine();
            return 1;
        }
    }
}
