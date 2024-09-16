<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrintHello extends Command
{
    protected $signature = 'print:hello';

    protected $description = 'Prints Hello every 5 seconds';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $logFile = base_path('/public/hello_log.txt');
        while (true) {
            $timestamp = date('Y-m-d H:i:s'); // Get the current timestamp using native PHP
            $message = "$timestamp - Hello\n"; // Format the log message

            file_put_contents($logFile, $message, FILE_APPEND); // Append the message to the log file

            sleep(5); // Wait for 5 seconds
        }
    }
}
