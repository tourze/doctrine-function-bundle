<?php

namespace Tourze\DoctrineFunctionBundle\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\DoctrineFunctionBundle\DependencyInjection\ORMConfigurationPass;
use Tourze\DoctrineFunctionBundle\DoctrineFunctionBundle;

/**
 * 测试 Bundle 的初始化
 */
class BundleInitializationTest extends TestCase
{
    public function testInitializeBundle(): void
    {
        // 验证 Bundle 可正确实例化
        $doctrineFunctionBundle = new DoctrineFunctionBundle();
        $this->assertInstanceOf(DoctrineFunctionBundle::class, $doctrineFunctionBundle);

        // 测试 ContainerBuilder 的构建
        $container = new ContainerBuilder();

        // 调用 Bundle 的构建方法
        $doctrineFunctionBundle->build($container);

        // 检查是否有编译通道注册，至少要有我们的 ORMConfigurationPass
        $passes = $container->getCompilerPassConfig()->getPasses();
        $this->assertNotEmpty($passes, '编译通道应该被添加到容器');

        // 检查是否有 ORMConfigurationPass 实例
        $hasORMConfigPass = false;
        foreach ($passes as $pass) {
            if ($pass instanceof ORMConfigurationPass) {
                $hasORMConfigPass = true;
                break;
            }
        }
        $this->assertTrue($hasORMConfigPass, '应该有 ORMConfigurationPass 实例');
    }
}
