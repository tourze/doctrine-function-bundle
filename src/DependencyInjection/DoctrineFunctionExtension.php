<?php

namespace Tourze\DoctrineFunctionBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Tourze\SymfonyDependencyServiceLoader\AutoExtension;

class DoctrineFunctionExtension extends AutoExtension
{
    protected function getConfigDir(): string
    {
        return __DIR__ . '/../Resources/config';
    }

    public function getAlias(): string
    {
        return 'doctrine_function';
    }
}
