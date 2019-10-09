<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use App\Middleware\AppAuthenticationMiddleware;
use App\Policy\RequestPolicy;
use App\Resolver\AclResolver;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Middleware\RequestAuthorizationMiddleware;
use Authorization\Policy\MapResolver;
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Http\ServerRequest;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use DateTime;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface, AuthorizationServiceProviderInterface {
    /**
     * {@inheritDoc}
     */
    public function bootstrap(): void {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        $this->addPlugin('Acl');
        $this->addPlugin('Authentication');
        $this->addPlugin('Authorization');

        $this->addPlugin('CakePdf');

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            $this->addPlugin('DebugKit');
        }

        // Load more plugins here
    }

    /**
     * Returns a service provider instance.
     *
     * @param ServerRequestInterface $request
     * @return AuthenticationServiceInterface
     * @throws \Exception
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface {
        $service = new AuthenticationService([
            //Do not redirect!
            'unauthenticatedRedirect' => null, //'/users/login'
        ]);

        $fields = [
            'username' => 'username',
            'password' => 'password'
        ];

        // Load identifiers
        $service->loadIdentifier('Authentication.Password', [
            'fields' => $fields
        ]);

        // Load the authenticators, you want session first
        $expireAt = new DateTime();
        $expireAt->setTimestamp(time() + (3600 * 24 * 31)); // In one month
        $service->loadAuthenticator('Authentication.Cookie', [
            'rememberMeField' => 'remember_me',
            'cookie'          => [
                'expire' => $expireAt
            ]
        ]);
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields'   => $fields,
            'loginUrl' => '/users/login',
        ]);

        return $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @return AuthorizationServiceInterface
     */
    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface {
        $mapResolver = new MapResolver();
        $mapResolver->map(ServerRequest::class, RequestPolicy::class);
        return new AuthorizationService($mapResolver);
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue {
        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(null, Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new EncryptedCookieMiddleware(
            // Names of cookies to protect
                ['secrets', 'protected', 'CookieAuth'],
                Configure::read('Security.cookieKey')
            ))

            // Add routing middleware.
            // If you have a large number of routes connected, turning on routes
            // caching in production could improve performance. For that when
            // creating the middleware instance specify the cache config name by
            // using it's second constructor argument:
            // `new RoutingMiddleware($this, '_cake_routes_')`
            //
            // RoutingMiddleware will also parse URL and make $request->getParam('controller') work
            ->add(new RoutingMiddleware($this))

            //Add the authentication middleware
            //Response a 403 to .json requests and redirect .html requests to login page
            ->add(new AppAuthenticationMiddleware($this, [
                //Only redirect .html requests if login is invalid - no json requests
                'htmlUnauthenticatedRedirect' => '/users/login'
            ]))
            ->add(new AuthorizationMiddleware($this))
            ->add(new RequestAuthorizationMiddleware());

        return $middlewareQueue;
    }

    /**
     * @return void
     */
    protected function bootstrapCli(): void {
        try {
            $this->addPlugin('Bake');
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }

        $this->addPlugin('Migrations');

        // Load more plugins here
    }
}
