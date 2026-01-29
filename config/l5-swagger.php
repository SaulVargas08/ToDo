<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Task Manager API',
                'description' => 'API para gestionar proyectos, tareas, subtareas y etiquetas.',
                'version' => '1.0.0',
                'termsOfService' => '',
                'contact' => [
                    'email' => 'support@taskmanager.com',
                ],
                'license' => [
                    'name' => 'Apache 2.0',
                    'url' => 'http://www.apache.org/licenses/LICENSE-2.0.html',
                ],
            ],
            'routes' => [
                /*
                 * Ruta para acceder a la interfaz de documentación de la API
                 */
                'api' => 'api/documentation',
            ],
            'paths' => [
                /*
                 * Usar una URL absoluta para los assets de Swagger UI
                 */
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),

                /*
                 * Carpeta donde se almacenarán los assets de Swagger UI
                 */
                'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', 'vendor/swagger-api/swagger-ui/dist/'),

                /*
                 * Nombre del archivo JSON generado para la documentación
                 */
                'docs_json' => 'api-docs.json',

                /*
                 * Nombre del archivo YAML generado para la documentación
                 */
                'docs_yaml' => 'api-docs.yaml',

                /*
                 * Formato que Swagger UI usará (json o yaml)
                 */
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),

                /*
                 * Directorio donde se buscarán las anotaciones para la documentación
                 */
                'annotations' => [
                    base_path('app'),
                ],

                /*
                 * Directorios o archivos que deben ser excluidos de la documentación
                 */
                'excludes' => [], // Se agrega esta clave para evitar errores
            ],
        ],
    ],
    'defaults' => [
        'routes' => [
            /*
             * Ruta para acceder a las anotaciones procesadas de Swagger
             */
            'docs' => 'docs',

            /*
             * Middleware para proteger el acceso a la documentación de la API
             */
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
        ],

        'paths' => [
            /*
             * Carpeta donde se almacenará la documentación procesada
             */
            'docs' => storage_path('api-docs'),

            /*
             * Carpeta para exportar vistas (opcional)
             */
            'views' => base_path('resources/views/vendor/l5-swagger'),

            /*
             * Ruta base de la API (si usas prefijos o subdominios)
             */
            'base' => env('L5_SWAGGER_BASE_PATH', null),

            /*
             * Directorios o archivos que deben ser excluidos de la documentación
             */
            'excludes' => [], // Se asegura que esté en todas las configuraciones
        ],

        /*
         * Seguridad de la API
         */
        'securityDefinitions' => [
            'securitySchemes' => [
                'bearerAuth' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'JWT',
                    'description' => 'Introduce el token en el formato: Bearer {token}',
                ],
            ],
            'security' => [
                [
                    'bearerAuth' => [],
                ],
            ],
        ],

        /*
         * Configuración para generar automáticamente los documentos en cada solicitud
         */
        'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),

        /*
         * Permitir generación de una copia en YAML
         */
        'generate_yaml_copy' => env('L5_SWAGGER_GENERATE_YAML_COPY', false),
    ],

    /*
     * Constantes que puedes usar en las anotaciones de Swagger
     */
    'constants' => [
        'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost'),
    ],
];
