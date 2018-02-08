<?php namespace AdammBalogh\Box\Client\Content;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

abstract class AbstractClient extends GuzzleClient
{
    protected $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;

        parent::__construct([
            'base_uri' => static::URI . '/'.static::API_VERSION,
            'defaults' => [
                'headers' => ['Authorization' => 'Bearer ' . $accessToken],
            ]
        ]);
    }

    function add_header($header, $value)
    {
	    return function (callable $handler) use ($header, $value) {
		    return function (
				    RequestInterface $request,
				    array $options
				    ) use ($handler, $header, $value) {
			    $request = $request->withHeader($header, $value);
			    return $handler($request, $options);
		    };
	    };
    }	

    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
