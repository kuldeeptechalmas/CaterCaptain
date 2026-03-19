<?php

namespace App\Console\Commands;

use App\Events\LowStockEvent;
use App\Jobs\LowStockEmailJobs;
use App\Models\Notifications;
use App\Models\User;
use App\Notifications\LowStockNotifications;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mime\Email;

class LowStockNotificationAndEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:low-stock-notification-and-email-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $raw_materials = DB::table('raw_materials')
            ->whereColumn('qty', '<=', 'min_qty')
            ->get();

        if ($raw_materials->isNotEmpty()) {

            $notification  = new Notifications();
            $notification->user_id = 1;
            $notification->message = 'Low Stock Alert 🚨';
            $notification->type = 'low_stock';
            $notification->data = implode(',', $raw_materials->pluck('name')->toArray());
            $notification->ref_id = null;
            $notification->is_read = false;
            $notification->save();

            event(new LowStockEvent($notification));

            // LowStockEmailJobs::dispatch($raw_materials, 'kuldeeptechalmas@gmail.com');


            Log::info('Low stock alert for raw materials:' . json_encode($raw_materials));
        } else {
            Log::info('No low stock alert for raw materials.');
        }
    }
}
