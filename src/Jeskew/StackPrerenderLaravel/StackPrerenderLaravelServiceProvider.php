<?php namespace Jeskew\StackPrerenderLaravel;

use Illuminate\Support\ServiceProvider;

class StackPrerenderLaravelServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('jeskew/stack-prerender-laravel');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->middleware('Jeskew\StackPhPrerender\Kernel', [
            $this->filterNulls([
                'prerenderToken' => $this->getEnvVar('PRERENDER_TOKEN'),
                'blacklist' => $this->getEnvVar('PRERENDER_BLACKLIST'),
                'whitelist' => $this->getEnvVar('PRERENDER_WHITELIST'),
                'backendUrl' => $this->getEnvVar('PRERENDER_BACKEND_URL'),
            ])
        ]);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

    protected function filterNulls(array $data)
    {
        return array_filter($data, function ($datum) {
            return $datum !== null;
        });
    }

    protected function getEnvVar($key)
    {
        return isset($_ENV[$key]) ? $_ENV[$key] : null;
    }

}
