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
}
