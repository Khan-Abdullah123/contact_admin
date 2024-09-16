<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendSingleEmail extends Command
{
    protected $signature = 'email:send-single {count}';
    protected $description = 'Send a specified number of emails per day, tracking progress in a JSON file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $emailLimit = (int) env('MAIL_LIMIT');
        $requestedCount = (int) $this->argument('count');
        $to = 'pathanrehankhan68@gmail.com';
        $logFile = base_path('public/email_log.json');
        $logData = $this->loadJsonFile($logFile);
        $today = date('Y-m-d');
        if (isset($logData['date']) && $logData['date'] === $today) {
            $emailCount = $logData['count'];
        } else {
            $emailCount = 0;
            $logData = ['date' => $today, 'count' => 0];
        }
        $emailsRemaining = $emailLimit - $emailCount;
        $emailsToSend = min($requestedCount, $emailsRemaining);

        if ($emailsToSend <= 0) {
            $this->info("Daily email limit reached. Cannot send more emails today.");
            return;
        }
        $subject = 'Weekly Update on Email Command Project';
        $message = "Dear Talha,
        I hope you are doing well.
        Here’s a quick update on our progress regarding the Email Command project:
        Current Status: We have successfully implemented the core functionality to send emails via command.
        Pending Tasks: We're finalizing error handling and logging mechanisms to ensure email dispatches are tracked properly.
        Next Steps: Testing completion before deployment.
        Best regards, Khan Abdullah";
        for ($i = 0; $i < $emailsToSend; $i++) {
            Mail::raw($message, function ($email) use ($to, $subject) {
                $email->to($to)
                      ->subject($subject);
            });
            $emailCount++;
            $logData['count'] = $emailCount;

            $timestamp = date('Y-m-d H:i:s');
            $this->info("$timestamp - Email sent successfully ($emailCount/$emailLimit)");
            file_put_contents($logFile, json_encode($logData));
        }
        $this->info("Sent $emailsToSend emails out of requested $requestedCount.");
    }
    private function loadJsonFile($path)
    {
        if (file_exists($path)) {
            $content = file_get_contents($path);
            return json_decode($content, true) ?? ['date' => null, 'count' => 0];
        }
        return ['date' => null, 'count' => 0];
    }
}
