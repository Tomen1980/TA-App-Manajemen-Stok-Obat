<?php

namespace App\Notifications;

use App\Services\MedicineMasterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\Telegram;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Carbon\Carbon;

class ExampleNotification extends Notification
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

     protected function analyzeBatches($batches)
{
    $now = now();
    $analysis = [
        'Layak Pakai (>3 bulan)' => 0,
        'Segera Digunakan (<3 bulan)' => 0,
        'Expired' => 0
    ];
    
    foreach ($batches as $batch) {
        $expiryDate = \Carbon\Carbon::parse($batch->expired_date);
        $diffMonths = $now->diffInMonths($expiryDate, false);
        
        if ($expiryDate <= $now) {
            $analysis['Expired']++;
        } elseif ($diffMonths <= 3) {
            $analysis['Segera Digunakan (<3 bulan)']++;
        } else {
            $analysis['Layak Pakai (>3 bulan)']++;
        }
    }
    
    return $analysis;
}

    public function toTelegram(object $notifiable)
    {
        try{
            $medicines = $this->medicineService->findAll();
            $id_group = config("services.telegram-bot-api.id_group");
            $now = now();
            $message = "📊 *LAPORAN STOK OBAT* 📊\n";
            $message .= "📅 *" . $now->format('d-M-Y H:i') . "* \n\n";
            
            foreach ($medicines as $medicine) {
                // Hitung stok valid (total stok - expired)
                $expiredBatches = $medicine->batch_drugs
                    ->where('expired_date', '<=', now()->format('Y-m-d'));
                    
                $expiredStock = $expiredBatches->sum('batch_stock');
                $validStock = $medicine->stock - $expiredStock;
                
                // Status stok
                $stockStatus = ($validStock <= $medicine->min_stock) 
                    ? "❌ *KRITIS* (Perlu restock!)" 
                    : "✅ *AMAN*";
                
                // Analisis batch
                $batchAnalysis = $this->analyzeBatches($medicine->batch_drugs);
                
                $message .= "💊 *{$medicine->name}*\n";
                $message .= "├─ Stok Total: {$medicine->stock}\n";
                $message .= "├─ Stok Expired: {$expiredStock}\n";
                $message .= "├─ Stok Valid: {$validStock}\n";
                $message .= "├─ Minimal Stok: {$medicine->min_stock}\n";
                $message .= "├─ Status: {$stockStatus}\n";
                $message .= "└─ Analisis Batch:\n";
                
                foreach ($batchAnalysis as $status => $count) {
                    $message .= "   ├─ {$status}: {$count} batch\n";
                }
                
                $message .= "\n";
            }
            
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
