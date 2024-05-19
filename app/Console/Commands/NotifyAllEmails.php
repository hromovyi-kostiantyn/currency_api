<?php

namespace App\Console\Commands;

use App\Models\Subscriber;
use App\Notifications\SendCurrentCurrency;
use App\Services\CurrencyService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class NotifyAllEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-all-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all subscribers with the latest currency rates.';


    public function __construct(
        protected CurrencyService $currencyService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $data = $this->currencyService->getCurrentCurrency();
        } catch (\Exception $e) {
            return;
        }

        $output = $this->currencyService->generateOutput($data);

        Subscriber::chunk(100, function ($subscribers) use ($output) {

            foreach ($subscribers as $subscriber) {
                $subscriber->notify(new SendCurrentCurrency($output));
            }
        });
    }
}
