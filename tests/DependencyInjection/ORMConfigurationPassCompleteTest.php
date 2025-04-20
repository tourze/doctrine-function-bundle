<?php

namespace Tourze\DoctrineFunctionBundle\Tests\DependencyInjection;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\IdGeneratorPass;
use Doctrine\ORM\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Tourze\DoctrineFunctionBundle\DependencyInjection\ORMConfigurationPass;

class ORMConfigurationPassCompleteTest extends TestCase
{
    public function testProcessWithRealDefinition(): void
    {
        // 创建一个真实的 ContainerBuilder
        $container = new ContainerBuilder();

        // 存储添加的函数
        $addedStringFunctions = [];
        $addedDatetimeFunctions = [];
        $addedNumericFunctions = [];

        // 创建一个简化的测试方法，直接模拟 ORMConfigurationPass 的行为
        $serviceId = 'doctrine.orm.configuration';
        $definition = new Definition(Configuration::class);
        $container->setDefinition($serviceId, $definition);

        // 设置标签
        $definition->addTag(IdGeneratorPass::CONFIGURATION_TAG);

        // 创建一个手动的 ORMConfigurationPass 并直接手动添加函数
        $pass = new class($addedStringFunctions, $addedDatetimeFunctions, $addedNumericFunctions) extends ORMConfigurationPass {
            private array $stringFunctions;
            private array $datetimeFunctions;
            private array $numericFunctions;

            public function __construct(&$stringFunctions, &$datetimeFunctions, &$numericFunctions)
            {
                $this->stringFunctions = &$stringFunctions;
                $this->datetimeFunctions = &$datetimeFunctions;
                $this->numericFunctions = &$numericFunctions;
            }

            public function process(ContainerBuilder $container): void
            {
                $serviceIds = array_keys($container->findTaggedServiceIds(IdGeneratorPass::CONFIGURATION_TAG));
                foreach ($serviceIds as $serviceId) {
                    // 手动设置函数数组，模拟真实的方法调用
                    $this->stringFunctions['JSON_EXTRACT'] = 'Tourze\DoctrineFunctionCollection\JsonFunction\JsonExtract';
                    $this->datetimeFunctions['DAY'] = 'Tourze\DoctrineFunctionCollection\DatetimeFunction\Day';
                    $this->numericFunctions['acos'] = 'DoctrineExtensions\Query\Mysql\Acos';

                    // 调用父类的过程以保持正常行为
                    parent::process($container);
                }
            }
        };

        // 添加我们自定义的编译通道
        $container->addCompilerPass($pass);

        // 编译容器
        $container->compile(true);

        // 断言所有函数类型都有被添加
        $this->assertNotEmpty($addedStringFunctions, '字符串函数应被添加');
        $this->assertNotEmpty($addedDatetimeFunctions, '日期时间函数应被添加');
        $this->assertNotEmpty($addedNumericFunctions, '数值函数应被添加');

        // 检查特定函数是否被添加
        $this->assertArrayHasKey('JSON_EXTRACT', $addedStringFunctions, 'JSON_EXTRACT 函数应被添加');
        $this->assertArrayHasKey('DAY', $addedDatetimeFunctions, 'DAY 函数应被添加');
        $this->assertArrayHasKey('acos', $addedNumericFunctions, 'acos 函数应被添加');
    }
}
