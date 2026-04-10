<?php

namespace App\Services;

use App\Models\WaitlistEntry;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $token;
    protected string $chatId;
    protected string $apiBase;

    public function __construct()
    {
        $this->token   = config('proofwork.telegram_bot_token', '');
        $this->chatId  = config('proofwork.telegram_chat_id', '');
        $this->apiBase = "https://api.telegram.org/bot{$this->token}";
    }

    public function notifyNewSignup(WaitlistEntry $entry, int $total): void
    {
        if (empty($this->token) || empty($this->chatId)) {
            Log::warning('Telegram not configured.');
            return;
        }

        $plan = ucfirst($entry->plan_interest);
        $source = $entry->source ?? 'direct';
        $time = $entry->created_at->format('d M Y H:i');

        $message = "New ProofWork signup!\n\n"
            . "Email: {$entry->email}\n"
            . ($entry->name ? "Name: {$entry->name}\n" : '')
            . "Plan: {$plan}\n"
            . "Source: {$source}\n"
            . "Time: {$time} UTC\n\n"
            . "Total on waitlist: {$total}";

        $this->sendMessage($message);
    }

    public function sendMessage(string $text): void
    {
        try {
            $response = Http::timeout(10)->post("{$this->apiBase}/sendMessage", [
                'chat_id' => $this->chatId,
                'text'    => $text,
            ]);

            if (!$response->successful()) {
                Log::error('Telegram API error: ' . $response->body());
            }
        } catch (\Throwable $e) {
            Log::error('Telegram HTTP error: ' . $e->getMessage());
        }
    }
}