<?php

namespace App\OpenApi;

use ArrayObject;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\Response;
use ApiPlatform\OpenApi\Model\Operation;
use App\Controller\ValidationController;
use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;

class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        $openApi->getPaths()->addPath('/api/login', new PathItem(
            post: new Operation(
                operationId: 'postLogin',
                tags: ['Authentication'],
                summary: 'Authenticate and receive an access token',
                description: 'Allows an admin to log in by providing a username and password, and receive a token if credentials are valid.',
                requestBody: new \ApiPlatform\OpenApi\Model\RequestBody(
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

        $openApi->getPaths()->addPath('/api/logout', new PathItem(
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

        $validationControllerReflection = new \ReflectionClass(ValidationController::class);
        $validationControllerReflectionRoute = rtrim(
            $validationControllerReflection->getAttributes(Route::class)[0]->newInstance()->getPath(),
            '/'
        );

        foreach ($validationControllerReflection->getMethods() as $method) {
            foreach ($method->getAttributes(Route::class) as $attribute) {
                $route = $attribute->newInstance();
                $subPath = ltrim($route->getPath(), '/');
                $fullPath = "{$validationControllerReflectionRoute}/{$subPath}";

                $operationId = "getValidationRules" . ucfirst(str_replace(['/', '-'], '', $fullPath));

                $openApi->getPaths()->addPath($fullPath, new PathItem(
                    get: new Operation(
                        operationId: $operationId,
                        tags: ['Validation Rules'],
                        summary: "Get validation rules for {$fullPath}",
                        description: "Returns validation rules for {$fullPath}",
                        responses: [
                            '200' => new Response(
                                description: "Successful response with {$fullPath} validation rules",
                                content: new ArrayObject([
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'example' => [
                                                'field1' => 'required|string|max:255',
                                                'field2' => 'optional|integer',
                                            ],
                                        ],
                                    ],
                                ])
                            ),
                            '400' => new Response(description: 'Bad request'),
                        ]
                    )
                ));
            }
        }

        return $openApi;
    }
}
