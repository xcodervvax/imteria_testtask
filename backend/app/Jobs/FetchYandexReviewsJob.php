<?php

namespace App\Jobs;

use App\Models\Account;
use App\Services\YandexReviewService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchYandexReviewsJob implements ShouldQueue
{
    use Queueable;

    protected Account $account;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->account = $account;
    }

    /**
     * Execute the job.
     */
    public function handle(YandexReviewService $service): void
    {
        $service->fetch($this->account);
    }
}
