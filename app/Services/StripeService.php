<?php

declare(strict_types=1);

namespace App\Services;

use Throwable;

class StripeService
{
    private $client;
    private $enabled = false;

    public function __construct()
    {
        $apiKey = config('services.stripe.secret');
        if ($apiKey) {
            // Load Stripe SDK
            require_once base_path('vendor/stripe/stripe-php/init.php');
            
            // Create StripeClient instance
            $this->client = new \Stripe\StripeClient($apiKey);
            $this->enabled = true;
        }
    }

    /**
     * Check if Stripe is enabled
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Create a Stripe checkout session.
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     *
     * @throws Throwable
     */
    public function createCheckoutSession(array $params): array
    {
        if (!$this->enabled) {
            // Return a mock session for testing without Stripe
            return [
                'id' => 'test_' . uniqid(),
                'url' => route('features.thank_you'),
                'object' => (object)[
                    'id' => 'test_' . uniqid(),
                    'url' => route('features.thank_you'),
                ],
            ];
        }

        try {
            $session = $this->client->checkout->sessions->create($params);

            return [
                'id' => $session->id,
                'url' => $session->url,
                'object' => $session,
            ];
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}
