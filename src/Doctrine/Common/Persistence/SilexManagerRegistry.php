<?php

namespace Doctrine\Common\Persistence;

use Silex\Application;

/**
 * @author Andy Stanberry <andystanberry@gmail.com>
 */
class SilexManagerRegistry extends AbstractManagerRegistry
{
    protected $app;

    /**
     * @param Silex\Application $app
     */
    public function setApplication(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $name
     */
    protected function getService($name)
    {
        return $this->app[$name];
    }

    /**
     * @param string $name
     */
    protected function resetService($name)
    {
        unset($this->app[$name]);
    }

    /**
     * Resolves a registered namespace alias to the full namespace.
     *
     * @param string $alias
     * @return string
     * @throws MongoDBException
     */
    public function getAliasNamespace($alias)
    {
        foreach (array_keys($this->getManagers()) as $name) {
            try {
                $config = $this->getManager($name)->getConfiguration();

                if ($config instanceof Doctrine\ORM\Configuration) {
                    return $config->getEntityNamespace($alias);
                }

                if ($config instanceof Doctrine\ODM\MongoDB\Configuration) {
                    return $config->getDocumentNamespace($alias);
                }
            } catch (\Exception $e) {
            }
        }

        throw new \InvalidArgumentException('Alias namespace not found');
    }
}
