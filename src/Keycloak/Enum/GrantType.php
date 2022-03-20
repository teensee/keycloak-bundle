<?php

namespace KeycloakBundle\Keycloak\Enum;

enum GrantType: string
{
    case PASSWORD = 'password';
    case CLIENT_CREDENTIALS = 'client_credentials';
    case REFRESH_TOKEN = 'refresh_token';
}