<?php

namespace Tourze\DoctrineFunctionBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\DoctrineFunctionBundle\DoctrineFunctionBundle;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;

/**
 * 测试 Bundle 的初始化
 *
 * @internal
 */
#[CoversClass(DoctrineFunctionBundle::class)]
#[RunTestsInSeparateProcesses]
final class BundleInitializationTest extends AbstractBundleTestCase
{
    public function testInitializeBundle(): void
    {
        // 验证 Bundle 可正确实例化 - 通过容器获取服务而非直接实例化
        $kernel = self::bootKernel();
        $container = $kernel->getContainer();

        // 验证Bundle已正确加载
        $bundles = $kernel->getBundles();
        $this->assertArrayHasKey('DoctrineFunctionBundle', $bundles);
        $this->assertInstanceOf(DoctrineFunctionBundle::class, $bundles['DoctrineFunctionBundle']);
    }
}
