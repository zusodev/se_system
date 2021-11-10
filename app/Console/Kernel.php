<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use function dump;
use function storage_path;

class Kernel extends ConsoleKernel
{
    protected $commands = [];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command("mail:job:dispatch")
            ->everyMinute();
        $schedule->command("mail:job:finish")
            ->everyMinute();



//        ResendMailsJob::dispatch();

        // TestQueueIsWorkingJob::dispatch();
        // $this->pressureTest();

    }

    protected function commands()
    {
        $this->load(__DIR__ . "/Commands");

        require base_path("routes/console.php");
    }

    /*    protected function pressureTest(): void
        {
            $emails = [
                "matt@zuso.ai",
                "zo@zuso.ai",
                "wei@zuso.tw",
            ];
            SendEmailPressureTestJob::dispatch($emails, 200);
        }*/
}
