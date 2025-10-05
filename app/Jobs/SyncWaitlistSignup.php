<?php

namespace App\Jobs;

use App\Models\WaitlistSignup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyncWaitlistSignup implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public string $waitlistSignupId) {}

    public function handle(): void
    {
        $signup = WaitlistSignup::query()->find($this->waitlistSignupId);

        if (! $signup) {
            return;
        }

        $config = config('services.waitlist', []);
        $endpoint = $config['endpoint'] ?? null;

        if (blank($endpoint)) {
            Log::notice('Skipping waitlist sync because no endpoint is configured.', [
                'waitlist_signup_id' => $this->waitlistSignupId,
            ]);

            return;
        }

        $payload = [
            'email' => $signup->email,
            'name' => $signup->name,
            'source' => $signup->source,
            'meta' => $signup->meta ?? [],
        ];

        if (! blank($listId = $config['list_id'] ?? null)) {
            $payload['list_id'] = $listId;
        }

        try {
            $request = Http::asJson()->timeout(10);

            if (! blank($token = $config['token'] ?? null)) {
                $request = $request->withToken($token);
            }

            $response = $request->post($endpoint, $payload);

            if ($response->failed()) {
                Log::warning('Waitlist sync failed.', [
                    'waitlist_signup_id' => $signup->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                $response->throw();
            }
        } catch (Throwable $e) {
            Log::error('Waitlist sync encountered an exception.', [
                'waitlist_signup_id' => $this->waitlistSignupId,
                'exception' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
