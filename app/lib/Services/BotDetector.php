<?php namespace Lib\Services;

class BotDetector {

	private $userAgents = [
		'baiduspider',
		'facebookexternalhit',
		'twitterbot',
		'rogerbot',
		'linkedinbot',
		'embedly',
		'quora link preview',
		'showyoubot',
		'outbrain',
		'pinterest',
		'developers.google.com/+/web/snippet',
		'googlebot',
	];

	public function requestIsFromBot($request)
	{
		$userAgent   = strtolower($request->server->get('HTTP_USER_AGENT'));
		$bufferAgent = $request->server->get('X-BUFFERBOT');

		$shouldPrerender = false;

		if (!$userAgent) return false;

		if (!$request->isMethod('GET')) return false;

    	//google bot
		if ($request->query->has('_escaped_fragment_')) $shouldPrerender = true;

   		//other crawlers
		foreach ($this->userAgents as $crawlerUserAgent) {
			if (str_contains($userAgent, strtolower($crawlerUserAgent))) {
				$shouldPrerender = true;
			}
		}

		if ($bufferAgent) $shouldPrerender = true;

		if (!$shouldPrerender) return false;

		return true;
	}
}