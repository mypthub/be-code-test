<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use function count;

/**
 * Class ApiRequestMiddleware
 * @package App\Http\Middleware
 */
class ApiRequestMiddleware
{
    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (\is_string($request->route()->action['uses'])) {
            $req = explode('\\', $request->route()->action['uses']);

            if ($req) {
                $req = $req[count($req) - 1];
                [$controller, $action] = explode('@', $req, 2);

                $request->attributes->add([
                    '_controller' => lcfirst(str_replace('Controller', '', $controller)),
                    '_action' => lcfirst(str_replace('Action', '', $action)),
                ]);
            }
        }

        return $next($request);
    }
}
