<?php

namespace App\Jobs;

use App\Mail\LowStockAlertMail;
use App\Mail\LowStockEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LowStockEmailJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Collection $materials, public string $recipientEmail)
    {
        $this->materials = $materials;
        $this->recipientEmail = $recipientEmail;
    }

    public function handle(): void
    {
        Mail::to($this->recipientEmail)->send(new LowStockEmail($this->materials));
    }
}
