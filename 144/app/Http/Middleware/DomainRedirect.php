<?php

namespace App\Http\Middleware;

use Closure;

class DomainRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();

        $url = parse_url(config('app.url'));

        if (isset($url['host']) && $url['host'] !== $host) {
            $path = $request->path();
            $path = ($path == '' || $path == '/') ? '' : '/' . $path;
            $apiUrl = parse_url(config('riel.api.host'));

            if ($apiUrl['host'] == $host) {
                if (! preg_match('/^\\/(xml|csv)\\/v3\\.0\\/.+$/', $path)) {
                    return redirect()->to(config('app.url'));
                }
            } elseif (strpos($host, 'photron.hu') !== false) {
                return redirect()->to('https://www.im.riel.hu/gyorskamera');
            } else {
                $queryString = $request->getQueryString();

                return redirect()->to(config('app.url') . $path . ($queryString ? '?' . $queryString : ''));
            }
        }

        return $next($request);
    }
}
