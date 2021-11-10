<?php

namespace App\Jobs;

use App\Mail\TestEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Mail;
use function rand;
use function sleep;

class SendEmailPressureTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $emails;
    private $emailsCount;
    private $times;
    private $currentEmail;

    /**
     * SendEmailPressureTestJob constructor.
     * @param string[] $emails
     * @param int $times
     */
    public function __construct(array $emails, int $times = 0)
    {
        $this->emails = $emails;
        $this->emailsCount = count($this->emails);
        $this->times = $times;
    }

    public function handle()
    {
        for ($i = 1; $i <= $this->times; $i++) {
            sleep(rand(2, 4));

            $emailAddress = $this->getEmail($i);
            Log::info("(" . $i . "):send email to '" . $emailAddress . "'");

            Mail::to($emailAddress)
                ->send(new TestEmail());
        }
    }

    protected function getEmail(int $i): string
    {
        $this->currentEmail = $this->emails[$i % $this->emailsCount];
        return $this->currentEmail;
    }
}
