<?php

namespace App\Console\Commands;

use App\Notifications\DrugsExpiredReport;
use App\Services\MedicineMasterService;
use Illuminate\Console\Command;
use Notification;

class SendExpiredMedicineNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:expired-medicines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification about expired medicines to Telegram';

    /**
     * Execute the console command.
     */
    public function handle(MedicineMasterService $medicineMasterService)
    {
        $id_group = config('services.telegram-bot-api.id_group');
        
        Notification::route('telegram', $id_group)
            ->notify(new DrugsExpiredReport($medicineMasterService));
            
        $this->info('Expired medicines notification sent successfully!');
    }
}
