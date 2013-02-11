<?php

namespace Silex\Provider;

use Doctrine\Common\Persistence\SilexManagerRegistry;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * @author Andy Stanberry <andystanberry@gmail.com>
 */
class DoctrineManagerRegistryServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['doctrine.common.manager_registry.definitions'] = array();

        $defaults = array(
            'connections' => array(),
            'managers' => array(),
            'default_connection' => null,
            'default_manager' => null,
            'proxy_interface_name' => 'Doctrine\Common\Proxy'
        );

        $app['doctrine.common.manager_registry.map'] = $app->share(function(Application $app) use ($defaults) {
            $defs = $app['doctrine.common.manager_registry.definitions'];

            $map = array();

            foreach ($defs as $name => $def) {
                // apply defaults
                $def = array_replace($defaults, $def);

                if (empty($def['connections'])) {
                    throw new \InvalidArgumentException('You need to define at least one connection');
                }

                if (empty($def['managers'])) {
                    throw new \InvalidArgumentException('You need to define at least one manager');
                }

                if ($def['default_connection'] === null) {
                    $def['default_connection'] = array_shift(array_keys($input));
                }

                if ($def['default_manager'] === null) {
                    $def['default_manager'] = array_shift(array_keys($input));
                }

                $map[$name] = new SilexManagerRegistry(
                    $def['name'],
                    $def['connections'],
                    $def['managers'],
                    $def['defaultConnection'],
                    $def['defaultManager'],
                    $def['proxyInterfaceName']
                );

                $map[$name]->setApplication($app);
            }

            return $map;
        });
    }

    public function boot(Application $app)
    {
    }
}
