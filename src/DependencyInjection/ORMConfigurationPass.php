<?php

namespace Tourze\DoctrineFunctionBundle\DependencyInjection;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\IdGeneratorPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\DoctrineFunctionBundle\Registry\FunctionRegistry;

class ORMConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        // PHPStan ignore: This cannot be replaced with registerForAutoconfiguration() as we are not just collecting
        // services, but modifying existing Doctrine ORM configuration definitions at compile time.
        // @phpstan-ignore-next-line symfony.noFindTaggedServiceIdsCall
        $taggedServices = $container->findTaggedServiceIds(IdGeneratorPass::CONFIGURATION_TAG);
        $this->processTaggedServices($container, $taggedServices);
    }

    /**
     * @param array<string, array<array<string, mixed>>> $taggedServices
     */
    private function processTaggedServices(ContainerBuilder $container, array $taggedServices): void
    {
        foreach ($taggedServices as $serviceId => $tags) {
            $ormConfigDef = $container->getDefinition($serviceId);

            foreach (FunctionRegistry::getStringFunctions() as $name => $class) {
                $ormConfigDef->addMethodCall('addCustomStringFunction', [$name, $class]);
            }

            foreach (FunctionRegistry::getDatetimeFunctions() as $name => $class) {
                $ormConfigDef->addMethodCall('addCustomDatetimeFunction', [$name, $class]);
            }

            foreach (FunctionRegistry::getNumericFunctions() as $name => $class) {
                $ormConfigDef->addMethodCall('addCustomNumericFunction', [$name, $class]);
            }
        }
    }
}
