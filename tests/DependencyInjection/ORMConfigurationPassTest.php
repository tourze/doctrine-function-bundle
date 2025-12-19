<?php

namespace Tourze\DoctrineFunctionBundle\Tests\DependencyInjection;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\IdGeneratorPass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Tourze\DoctrineFunctionBundle\DependencyInjection\ORMConfigurationPass;

/**
 * @internal
 */
#[CoversClass(ORMConfigurationPass::class)]
final class ORMConfigurationPassTest extends TestCase
{
    public function testProcess(): void
    {
        // 使用匿名类实现替代 Mock Definition
        // 追踪 addMethodCall 调用次数以验证测试预期
        $addMethodCallCount = 0;
        $ormConfigDef = new class($addMethodCallCount) extends Definition {
            public function __construct(private int &$callCount)
            {
                parent::__construct();
            }

            
            public function addMethodCall(string $method, array $arguments = [], bool $returnsClone = false): static
            {
                ++$this->callCount;

                return $this;
            }

            public function getCallCount(): int
            {
                return $this->callCount;
            }
        };

        // 使用匿名类实现替代 Mock ContainerBuilder
        // 追踪方法调用以验证测试预期
        $findTaggedServiceIdsCallCount = 0;
        $getDefinitionCallCount = 0;
        $container = new class($findTaggedServiceIdsCallCount, $getDefinitionCallCount, $ormConfigDef) extends ContainerBuilder {
            public function __construct(
                private int &$findTaggedCallCount,
                private int &$getDefinitionCallCount,
                private Definition $ormConfigDef,
            ) {
                parent::__construct();
            }

            /**
             * @return array<string, array<int, array<string, mixed>>>
             */
            public function findTaggedServiceIds(string $name, bool $throwOnAbstract = false): array
            {
                ++$this->findTaggedCallCount;
                if (IdGeneratorPass::CONFIGURATION_TAG === $name) {
                    return ['doctrine.orm.configuration' => []];
                }

                return [];
            }

            public function getDefinition(string $id): Definition
            {
                ++$this->getDefinitionCallCount;
                if ('doctrine.orm.configuration' === $id) {
                    return $this->ormConfigDef;
                }
                throw new \InvalidArgumentException("Definition not found: {$id}");
            }

            public function getFindTaggedCallCount(): int
            {
                return $this->findTaggedCallCount;
            }

            public function getGetDefinitionCallCount(): int
            {
                return $this->getDefinitionCallCount;
            }
        };

        // 执行测试
        $pass = new ORMConfigurationPass();
        $pass->process($container);

        // 验证预期的方法调用
        $this->assertGreaterThanOrEqual(1, $ormConfigDef->getCallCount(), 'addMethodCall should be called at least once');
        $this->assertSame(1, $container->getFindTaggedCallCount(), 'findTaggedServiceIds should be called exactly once');
        $this->assertSame(1, $container->getGetDefinitionCallCount(), 'getDefinition should be called exactly once');
    }
}
