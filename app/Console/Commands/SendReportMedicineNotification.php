<?php

namespace App\Console\Commands;

use App\Notifications\ReportMedicineNotification;
use App\Services\MedicineMasterService;
use Illuminate\Console\Command;
use Notification;

class SendReportMedicineNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:report-medicines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification about total report medicines to Telegram';

    /**
     * Execute the console command.
     */
    public function handle(MedicineMasterService $medicineMasterService)
    {
        $id_group = config('services.telegram-bot-api.id_group');
        
        Notification::route('telegram', $id_group)
            ->notify(new ReportMedicineNotification($medicineMasterService));
            
        $this->info('Report medicines notification sent successfully!');
    }
}
