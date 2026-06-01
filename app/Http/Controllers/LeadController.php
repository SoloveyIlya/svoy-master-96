<?php

namespace App\Http\Controllers;

use App\Events\LeadCreated;
use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request)
    {
        $pageUrl = $request->input('page_url')
            ?: $request->headers->get('referer', '');

        $lead = Lead::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'comment' => $request->input('comment'),
            'landing_page_id' => $request->input('landing_page_id'),
            'page_url' => Str::limit($pageUrl, 255, ''),
            'utm_source' => $request->input('utm_source', $request->session()->get('utm_source')),
            'utm_medium' => $request->input('utm_medium', $request->session()->get('utm_medium')),
            'utm_campaign' => $request->input('utm_campaign', $request->session()->get('utm_campaign')),
            'utm_term' => $request->input('utm_term', $request->session()->get('utm_term')),
            'utm_content' => $request->input('utm_content', $request->session()->get('utm_content')),
            'referer' => $request->headers->get('referer'),
            'user_agent' => $request->userAgent(),
        ]);

        event(new LeadCreated($lead));

        $text = "🔔 <b>Новая заявка на сайте!</b>\n\n"
              . "👤 <b>Имя:</b> {$request->name}\n"
              . "📞 <b>Телефон:</b> {$request->phone}\n"
              . "💬 <b>Комментарий:</b> " . ($request->comment ?? 'Нет комментария');

        try {
            Http::post("https://api.telegram.org/bot" . config('services.telegram.bot_token') . "/sendMessage", [
                'chat_id' => config('services.telegram.chat_id'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
        } catch (\Exception $e) {
            Log::error("Ошибка отправки в Telegram: " . $e->getMessage());
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Заявка отправлена!'], 201);
        }

        return back()->with('success', 'Заявка успешно отправлена! Мы скоро с вами свяжемся.');
    }
}
