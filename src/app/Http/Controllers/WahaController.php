<?php

namespace App\Http\Controllers;

use App\Services\WahaService;

class WahaController extends Controller
{
    public function send()
    {
        $res = app(WahaService::class)->sendMessage(
            to: request('phone'),
            message: request('msg')
        );

        return response()->json($res);
    }
}
