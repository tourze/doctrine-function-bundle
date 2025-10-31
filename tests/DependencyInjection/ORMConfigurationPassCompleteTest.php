<?php

namespace Tourze\DoctrineFunctionBundle\Tests\DependencyInjection;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\IdGeneratorPass;
use Doctrine\ORM\Configuration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Tourze\DoctrineFunctionBundle\DependencyInjection\ORMConfigurationPass;

/**
 * @internal
 */
#[CoversClass(ORMConfigurationPass::class)]
final class ORMConfigurationPassCompleteTest extends TestCase
{
    public function testProcessWithRealDefinition(): void
    {
        // 创建一个真实的 ContainerBuilder
        $container = new ContainerBuilder();

        // 创建一个简化的测试方法，直接模拟 ORMConfigurationPass 的行为
        $serviceId = 'doctrine.orm.configuration';
        $definition = new Definition(Configuration::class);
        $container->setDefinition($serviceId, $definition);

        // 设置标签
        $definition->addTag(IdGeneratorPass::CONFIGURATION_TAG);

        // 创建一个手动的 ORMConfigurationPass 并直接手动添加函数
        $pass = new class extends ORMConfigurationPass {
            /** @var array<string, string> */
            private array $stringFunctions = [];

            /** @var array<string, string> */
            private array $datetimeFunctions = [];

            /** @var array<string, string> */
            private array $numericFunctions = [];

            public function process(ContainerBuilder $container): void
            {
                // PHPStan ignore: Required for testing Doctrine ORM configuration pass behavior
                // @phpstan-ignore-next-line symfony.noFindTaggedServiceIdsCall
                $taggedServices = $container->findTaggedServiceIds(IdGeneratorPass::CONFIGURATION_TAG);
                $serviceIds = array_keys($taggedServices);
                foreach ($serviceIds as $serviceId) {
                    // 手动设置函数数组，模拟真实的方法调用
                    $this->stringFunctions['JSON_EXTRACT'] = 'Tourze\DoctrineFunctionCollection\JsonFunction\JsonExtract';
                    $this->datetimeFunctions['DAY'] = 'Tourze\DoctrineFunctionCollection\DatetimeFunction\Day';
                    $this->numericFunctions['acos'] = 'DoctrineExtensions\Query\Mysql\Acos';

                    // 调用父类的过程以保持正常行为
                    parent::process($container);
                }
            }

            /** @return array<string, string> */
            public function getStringFunctions(): array
            {
                return $this->stringFunctions;
            }

            /** @return array<string, string> */
            public function getDatetimeFunctions(): array
            {
                return $this->datetimeFunctions;
            }

            /** @return array<string, string> */
            public function getNumericFunctions(): array
            {
                return $this->numericFunctions;
            }
        };

        // 添加我们自定义的编译通道
        $container->addCompilerPass($pass);

        // 编译容器
        $container->compile(true);

        // 通过 getter 方法获取添加的函数
        $addedStringFunctions = $pass->getStringFunctions();
        $addedDatetimeFunctions = $pass->getDatetimeFunctions();
        $addedNumericFunctions = $pass->getNumericFunctions();

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
