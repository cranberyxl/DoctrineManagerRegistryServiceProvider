# Doctrine MangagerRegistry Silex Service Provider

Provides the ability to build 1 or more Doctrine ManafgerRegistries for use in your Silex project.

## Composer

```json
{
    "require": {
        "cranberyxl/doctrine-manager-registry-provider": "*"
    }
}
```

## Register

``` php
<?php

use Silex\Provider\DoctrineManagerRegistryServiceProvider;

$app = new Silex\Application();

$app->register(new DoctrineManagerRegistryServiceProvider(), array(
    'doctrine.common.manager_registry.definitions' => array(
        'mongodb' => array(
            'connections' => array('default' => 'doctrine.mongodb.connection'),
            'managers' => array('default' => 'doctrine.mongodb.dm'),
            'default_connection' => 'default',
            'default_manager' => 'default',
            'proxy_interface_name' => 'Doctrine\ODM\MongoDB\Proxy\Proxy' // Defaults to Doctrine\Common\Proxy
        )
    ),
));
```

## Use

```php

$app['form.document_type'] = $app->share(function(Application $app) {
    return new DocumentType($app['doctrine.common.manager_registry.map']['mongodb']);
});

```
