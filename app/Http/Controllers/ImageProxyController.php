<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ImageProxyController
{
    public function __invoke()
    {
        $url = request()->query('url');

        abort_if(!$url, 404);

        $data = cache()->remember("image_" . hash('md5', $url), 60 * 60 * 24 * 7, function () use ($url) {
            $response = Http::get($url);

            if ($response->successful()) {
                return [
                    'content' => $response->body(),
                    'header' => $response->header('content-type'),
                ];
            }

            abort(404);
        });

        return response($data['content'], 200, [
            'Content-Type' => $data['header'],
        ]);
    }
}
