<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\OpenApi\Model\Response;
use ApiPlatform\OpenApi\OpenApi;
use ArrayObject;

class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        $openApi->getPaths()->addPath('/login', new PathItem(
            post: new Operation(
                operationId: 'postLogin',
                tags: ['Authentication'],
                summary: 'Authenticate and receive an access token',
                description: 'Allows an admin to log in by providing a username and password, and receive a token if credentials are valid.',
                requestBody: new RequestBody(
                    description: 'Login credentials',
                    content: new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'username' => ['type' => 'string'],
                                    'password' => ['type' => 'string'],
                                ],
                            ],
                            'example' => [
                                'username' => 'admin_username',
                                'password' => 'admin_password',
                            ],
                        ],
                    ])
                ),
                responses: [
                    '200' => new Response(
                        description: 'Successful login with Bearer token',
                        content: new ArrayObject([
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'token' => ['type' => 'string'],
                                        'expires_at' => ['type' => 'string', 'format' => 'date-time'],
                                        'token_type' => ['type' => 'string', 'example' => 'Bearer'],
                                    ],
                                ],
                            ],
                        ])
                    ),
                    '401' => new Response(description: 'Unauthorized - invalid credentials'),
                ]
            )
        ));

        $openApi->getPaths()->addPath('/logout', new PathItem(
            post: new Operation(
                operationId: 'postLogout',
                tags: ['Authentication'],
                summary: 'Logout the authenticated user',
                description: 'Logs out the authenticated user and invalidates their token.',
                responses: [
                    '204' => new Response(description: 'Successful logout, no content'),
                    '401' => new Response(description: 'Unauthorized - no valid token provided'),
                ]
            )
        ));

        return $openApi;
    }
}
