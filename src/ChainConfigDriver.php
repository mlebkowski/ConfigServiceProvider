<?php

namespace Igorw\Silex;

class ChainConfigDriver implements ConfigDriver
{
	/**
	 * @var ConfigDriver[]
	 */
    private $drivers;

    public function __construct(array $drivers)
    {
        $this->drivers = array_map(function(ConfigDriver $driver) { return $driver; }, $drivers);
    }

    public function load($filename)
    {
        $driver = $this->getDriver($filename);
        return $driver->load($filename);
    }

    public function supports($filename)
    {
        return (bool) $this->getDriver($filename);
    }

    private function getDriver($filename)
    {
        foreach ($this->drivers as $driver) {
            if ($driver->supports($filename)) {
                return $driver;
            }
        }

        return null;
    }
}
