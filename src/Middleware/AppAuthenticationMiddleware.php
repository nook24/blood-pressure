<?php

namespace App\Middleware;

use Authentication\Authenticator\UnauthenticatedException;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;

class AppAuthenticationMiddleware extends AuthenticationMiddleware implements MiddlewareInterface {

    /**
     * @var string|null
     */
    private $htmlUnauthenticatedRedirect = null;

    public function __construct($subject, $config = null) {
        parent::__construct($subject, $config);

        if (isset($config['htmlUnauthenticatedRedirect'])) {
            $this->htmlUnauthenticatedRedirect = $config['htmlUnauthenticatedRedirect'];
        }
    }


    /**
     * Callable implementation for the middleware stack.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        try {
            $response = parent::process($request, $handler);
        } catch (UnauthenticatedException $e) {
            $header = $request->getHeader('Accept');
            if (is_array($header)) {
                $header = $header[0];
            }

            $isJson = $header === 'application/json';
            if (!$isJson) {
                //Search URL for .json
                $url = $request->getUri();
                $isJson = mb_substr($url->getPath(), -5) === '.json';
            }

            if ($isJson) {
                //Do not redirect json requests
                $response = new Response();
                $response = $response->withStatus(401);
                return $response;
            }

            if ($this->htmlUnauthenticatedRedirect) {
                //Redirct .html requests
                return new RedirectResponse($this->htmlUnauthenticatedRedirect);
            }

            //Not json request or no htmlUnauthenticatedRedirect given so throw exception
            throw $e;
        }

        return $response;
    }

}
