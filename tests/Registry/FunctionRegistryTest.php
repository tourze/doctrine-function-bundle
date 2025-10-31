<?php

namespace Tourze\DoctrineFunctionBundle\Tests\Registry;

use DoctrineExtensions\Query\Mysql\Sin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionBundle\Registry\FunctionRegistry;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Day;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonExtract;

/**
 * @internal
 */
#[CoversClass(FunctionRegistry::class)]
class FunctionRegistryTest extends TestCase
{
    public function testGetStringFunctions(): void
    {
        $functions = FunctionRegistry::getStringFunctions();

        $this->assertIsArray($functions);
        $this->assertArrayHasKey('JSON_EXTRACT', $functions);
        $this->assertSame(JsonExtract::class, $functions['JSON_EXTRACT']);
    }

    public function testGetDatetimeFunctions(): void
    {
        $functions = FunctionRegistry::getDatetimeFunctions();

        $this->assertIsArray($functions);
        $this->assertArrayHasKey('DAY', $functions);
        $this->assertSame(Day::class, $functions['DAY']);
    }

    public function testGetNumericFunctions(): void
    {
        $functions = FunctionRegistry::getNumericFunctions();

        $this->assertIsArray($functions);
        $this->assertArrayHasKey('sin', $functions);
        $this->assertSame(Sin::class, $functions['sin']);
    }

    public function testGetAllFunctions(): void
    {
        $allFunctions = FunctionRegistry::getAllFunctions();

        $this->assertIsArray($allFunctions);
        $this->assertArrayHasKey(FunctionRegistry::TYPE_STRING, $allFunctions);
        $this->assertArrayHasKey(FunctionRegistry::TYPE_DATETIME, $allFunctions);
        $this->assertArrayHasKey(FunctionRegistry::TYPE_NUMERIC, $allFunctions);

        $this->assertSame(FunctionRegistry::getStringFunctions(), $allFunctions[FunctionRegistry::TYPE_STRING]);
        $this->assertSame(FunctionRegistry::getDatetimeFunctions(), $allFunctions[FunctionRegistry::TYPE_DATETIME]);
        $this->assertSame(FunctionRegistry::getNumericFunctions(), $allFunctions[FunctionRegistry::TYPE_NUMERIC]);
    }

    public function testFunctionTypesAreCorrect(): void
    {
        $this->assertSame('string', FunctionRegistry::TYPE_STRING);
        $this->assertSame('datetime', FunctionRegistry::TYPE_DATETIME);
        $this->assertSame('numeric', FunctionRegistry::TYPE_NUMERIC);
    }
}
