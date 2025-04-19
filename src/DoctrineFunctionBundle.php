<?php

namespace Tourze\DoctrineFunctionBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\DoctrineFunctionBundle\DependencyInjection\ORMConfigurationPass;

class DoctrineFunctionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ORMConfigurationPass());
    }
}
