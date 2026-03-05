<?php

namespace App\Listeners;

use App\Events\LeadCreated;
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

        $name = $this->escape($lead->name ?: '—');
        $phone = $lead->phone;
        $comment = $this->escape($lead->comment ?: '—');
        $pageUrl = $this->escape($lead->page_url);
        $date = $lead->created_at->format('d.m.Y H:i');

        $lines = [
            "📞 *Новая заявка\\!*",
            "",
            "Имя: {$name}",
            "Телефон: `{$phone}`",
            "Комментарий: {$comment}",
            "Страница: {$pageUrl}",
            "Дата: {$date}",
        ];

        try {
            $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => implode("\n", $lines),
                'parse_mode' => 'MarkdownV2',
            ]);

            if ($response->failed()) {
                Log::error('Telegram notification failed: ' . $response->body());
            }
        } catch (\Throwable $e) {
            Log::error('Telegram notification exception: ' . $e->getMessage());
        }
    }

    private function escape(string $text): string
    {
        return str_replace(
            ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'],
            ['\\_', '\\*', '\\[', '\\]', '\\(', '\\)', '\\~', '\\`', '\\>', '\\#', '\\+', '\\-', '\\=', '\\|', '\\{', '\\}', '\\.', '\\!'],
            $text,
        );
    }
}
