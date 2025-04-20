<?php

namespace Tourze\DoctrineFunctionBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\DoctrineFunctionBundle\DependencyInjection\ORMConfigurationPass;
use Tourze\DoctrineFunctionBundle\DoctrineFunctionBundle;

class DoctrineFunctionBundleTest extends TestCase
{
    public function testBuild(): void
    {
        /** @var ContainerBuilder&\PHPUnit\Framework\MockObject\MockObject $container */
        $container = $this->createMock(ContainerBuilder::class);

        // 验证 addCompilerPass 方法会被调用，且参数是 ORMConfigurationPass 的实例
        $container->expects($this->once())
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(ORMConfigurationPass::class));

        $bundle = new DoctrineFunctionBundle();
        $bundle->build($container);
    }
}
