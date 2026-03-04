<?php

namespace App\Listeners;

use App\Events\LeadCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTelegramNotification
{
    public function handle(LeadCreated $event): void
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (! $token || ! $chatId) {
            Log::warning('Telegram credentials not configured, skipping notification.');

            return;
        }

        $lead = $event->lead;

        $lines = [
            "📞 *Новая заявка!*",
            "",
            "Имя: " . ($lead->name ?: '—'),
            "Телефон: `{$lead->phone}`",
            "Комментарий: " . ($lead->comment ?: '—'),
            "Страница: {$lead->page_url}",
            "Дата: {$lead->created_at->format('d.m.Y H:i')}",
        ];

        try {
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => implode("\n", $lines),
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Throwable $e) {
            Log::error('Telegram notification failed: ' . $e->getMessage());
        }
    }
}
