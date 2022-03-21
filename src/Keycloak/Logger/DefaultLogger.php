<?php

namespace KeycloakBundle\Keycloak\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

final class DefaultLogger extends AbstractLogger
{
    const ID = 'keycloak.logger';

    public function __construct(private ?LoggerInterface $logger, private bool $debug = false)
    {
    }

    public function log($level, $message, array $context = []): void
    {
        $this->logger?->log(level: $level, message: $message, context: $context);
    }
}