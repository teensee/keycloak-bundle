<?php

namespace KeycloakBundle\Keycloak\Enum;

enum Method: string
{
    case POST = 'POST';
    case GET = 'GET';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
}