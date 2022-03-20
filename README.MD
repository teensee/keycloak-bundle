# Keycloak Admin API Bundle

1) Перед установкой создать файл keycloak.yaml
2) Пример конфигурации
```yaml
keycloak:
  http_client:
    base_uri: 'https://some-keycloak-url.com/auth/'
  realms:
    firstRealm:
      realmName: realmName
      connections:
        firstClient:
          clientId: clientName
          clientSecret: 'guid'
        secondClient:
          clientId: adminClientName
          clientSecret: 'guid'
          admin: true
```