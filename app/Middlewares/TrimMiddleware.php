<?php

namespace Middlewares;

use Src\Request;
use function Collect\collection;

class TrimMiddleware
{
    public function handle(Request $request)
    {
        collection($request->all())
            ->each(function ($value, $key, $request) {
                $request->set($key, is_string($value) ? trim($value) : $value);
            }, $request);

        return $request;
    }
}
