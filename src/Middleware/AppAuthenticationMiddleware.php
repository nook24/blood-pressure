<?php

namespace App\Middleware;

use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AppAuthenticationMiddleware extends AuthenticationMiddleware implements MiddlewareInterface {

    /**
     * Callable implementation for the middleware stack.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        $response = parent::process($request, $handler);

        $header = $request->getHeader('Accept');
        if (is_array($header)) {
            $header = $header[0];
        }
        $isJson = $header === 'application/json';
        if(!$isJson){
            $isJson = mb_substr($request->getAttribute('here'), -5, 5) === '.json';
        }

        $isRedirect = $response->getHeader('Location') !== null;
        if ($isJson && $isRedirect) {
            $response = $response->withoutHeader('Location');
            $response = $response->withStatus(401);
            return $response;
        }

        return $response;
    }

}
