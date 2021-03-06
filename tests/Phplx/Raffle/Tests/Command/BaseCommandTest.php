<?php

namespace Phplx\Raffle\Tests\Command;

use Phplx\Raffle\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

abstract class BaseCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Phplx\Raffle\Application
     */
    protected $application;
    protected $cacheDir;

    public function setUp()
    {
        $baseDir = realpath('./');
        $this->cacheDir = $baseDir.'/cache';

        $this->application = new Application();

        $configDirectories = array("{$baseDir}/config");

        $container = include $baseDir.'/src/Phplx/Raffle/container.php';

        $loader = new YamlFileLoader($container, new FileLocator($configDirectories));
        $loader->load('parameters.yaml.dist');

        $this->application->setContainer($container);
    }
}
