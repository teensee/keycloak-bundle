<?php

namespace KeycloakBundle\Keycloak\Client\Realization;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\DTO\Common\Response\Realization\Response;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\ActionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class KeycloakClient implements ClientInterface, LoggerAwareInterface
{
    private LoggerInterface $logger;
    public function __construct(private HttpClientInterface $keycloakClient)
    {
    }

    public function execute(ActionInterface $action): Response
    {
        $this->log($action);
        try {
            $response = $this->keycloakClient->request(
                $action->getMethod()->value,
                $action->getUri(),
                $action->getOptions()
            );

            $content    = $response->getContent();
            $headers    = $response->getHeaders();
            $statusCode = $response->getStatusCode();
        } catch (ClientExceptionInterface $e) {
            //todo: add 4xx error Handling
            $statusCode = $e->getResponse()->getStatusCode();
            $content = json_decode($e->getResponse()->getContent(false), true);
            $this->logger?->error("{$action->getMethod()->value} {$action->getUri()} return status code: {$statusCode}", ['responseBody' => $content]);
        } catch (RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            //todo: add 3xx/5xx handling
            $statusCode = $e->getResponse()->getStatusCode();
            $content = json_decode($e->getResponse()->getContent(false), true);
            $this->logger?->error("{$action->getMethod()->value} {$action->getUri()} return status code: {$statusCode}", ['responseBody' => $content]);
        }

        return new Response($content, $statusCode, $headers);
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    private function log(ActionInterface $action)
    {
        $this->logger?->info("{$action->getMethod()->value} {$action->getUri()}", ['options' => $action->getOptions()]);
    }
}