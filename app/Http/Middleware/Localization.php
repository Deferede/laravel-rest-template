<?php

namespace App\Http\Middleware;

use App\Exceptions\UnsupportedLanguageException;
use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

/**
 * Class Localization
 *
 */
class Localization
{

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = request()->header('Content-Language');

        if (!$locale) {
            $locale = $this->app->config->get('app.locale');
        }
        
        $availableLangs = $this->app->config->get('app.supported_languages');

        if (!array_key_exists($locale, $availableLangs)) {
            throw new UnsupportedLanguageException('Language not supported. Supported languages: ' . implode(', ', array_keys($availableLangs)));
        }

        $this->app->setLocale($locale);

        // get the response after the request is done
        $response = $next($request);

        // set Content Languages header in the response
        $response->headers->set('Content-Language', $locale);

        // return the response
        return $response;
    }
}
