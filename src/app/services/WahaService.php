<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WahaService
{
    protected $base;
    protected $key;
    protected $session;

    public function __construct()
    {
        $this->base = config('waha.base_url');
        $this->key = config('waha.api_key');
        $this->session = config('waha.session');
    }

    public function sendMessage($to, $message)
    {
        return Http::withHeaders([
            'Authorization' => "Bearer {$this->key}",
        ])->post("{$this->base}/api/{$this->session}/messages/text", [
            'to' => $to,
            'message' => $message,
        ])->json();
    }
}
