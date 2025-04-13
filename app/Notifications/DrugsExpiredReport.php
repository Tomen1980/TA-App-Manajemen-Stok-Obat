<?php

namespace App\Notifications;

use App\Services\MedicineMasterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class DrugsExpiredReport extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $medicineService;
    public function __construct(MedicineMasterService $medicineService)
    {
        $this->medicineService = $medicineService;
       
        //
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram(object $notifiable)
    {
        try{
            $expiredMedicines  = $this->medicineService->findMedicineWithExpiredBatch();

            if ($expiredMedicines->isEmpty()) {
                return TelegramMessage::create()
                    ->content("✅ Tidak ada obat yang expired hari ini");
            }
            $now = now();
            $message = "⚠️ *Daftar Obat Expired* ⚠️\n";
            $message .= "📅 *" . $now->format('d-M-Y H:i') . "* \n\n";
            foreach ($expiredMedicines as $medicine) {
                if($medicine->batch_drugs->isEmpty() == false){
                $message .= "\n💊 *{$medicine->name}* (ID: {$medicine->id})";
                    foreach ($medicine->batch_drugs as $batch) {
                        $message .= "\n- Batch: {$batch->no_batch}";
                        $message .= "\n  Expired: {$batch->expired_date}";
                        $message .= "\n  Total: {$batch->batch_stock} stock";
                    }
                }
            }
            $id_group = config("services.telegram-bot-api.id_group");

            return TelegramMessage::create()
            ->to($id_group)
            ->content($message)
            ->options(['parse_mode' => 'Markdown']);
        }catch(\Exception $e){
            \log::error($e->getMessage());
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
