<?php

namespace App\Http\Controllers\Billing;

use App\Billing\BillingManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhookController
{
    public function __invoke(Request $request, string $gateway)
    {
        $payload = app(BillingManager::class)->resolve()->handleWebhook($request);
        $eventId = $payload['event_id'] ?? null;

        if (!$eventId) {
            return response()->json(['message' => 'Missing event id.'], 422);
        }

        $exists = DB::connection('master')
            ->table('webhook_events')
            ->where('gateway', $gateway)
            ->where('event_id', $eventId)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Webhook already processed.'], 200);
        }

        DB::connection('master')->table('webhook_events')->insert([
            'gateway' => $gateway,
            'event_id' => $eventId,
            'payload' => json_encode($payload, JSON_THROW_ON_ERROR),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Webhook stored.'], 202);
    }
}
