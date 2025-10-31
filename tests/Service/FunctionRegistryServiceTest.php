<?php

namespace Tourze\DoctrineFunctionBundle\Tests\Service;

use DoctrineExtensions\Query\Mysql\Sin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionBundle\Service\FunctionRegistryService;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Day;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonExtract;

/**
 * @internal
 */
#[CoversClass(FunctionRegistryService::class)]
class FunctionRegistryServiceTest extends TestCase
{
    private FunctionRegistryService $service;

    protected function setUp(): void
    {
        $this->service = new FunctionRegistryService();
    }

    public function testGetRegisteredFunctions(): void
    {
        $functions = $this->service->getRegisteredFunctions();

        $this->assertIsArray($functions);
        $this->assertArrayHasKey(FunctionRegistryService::FUNCTION_TYPE_STRING, $functions);
        $this->assertArrayHasKey(FunctionRegistryService::FUNCTION_TYPE_DATETIME, $functions);
        $this->assertArrayHasKey(FunctionRegistryService::FUNCTION_TYPE_NUMERIC, $functions);
    }

    public function testIsFunctionRegistered(): void
    {
        $this->assertTrue($this->service->isFunctionRegistered('JSON_EXTRACT'));
        $this->assertTrue($this->service->isFunctionRegistered('DAY'));
        $this->assertTrue($this->service->isFunctionRegistered('sin'));
        $this->assertFalse($this->service->isFunctionRegistered('NONEXISTENT_FUNCTION'));
    }

    public function testGetFunctionsByType(): void
    {
        $stringFunctions = $this->service->getFunctionsByType(FunctionRegistryService::FUNCTION_TYPE_STRING);
        $this->assertArrayHasKey('JSON_EXTRACT', $stringFunctions);
        $this->assertArrayHasKey('FIELD', $stringFunctions);

        $datetimeFunctions = $this->service->getFunctionsByType(FunctionRegistryService::FUNCTION_TYPE_DATETIME);
        $this->assertArrayHasKey('DAY', $datetimeFunctions);
        $this->assertArrayHasKey('YEAR', $datetimeFunctions);

        $numericFunctions = $this->service->getFunctionsByType(FunctionRegistryService::FUNCTION_TYPE_NUMERIC);
        $this->assertArrayHasKey('sin', $numericFunctions);
        $this->assertArrayHasKey('cos', $numericFunctions);

        $emptyResult = $this->service->getFunctionsByType('invalid_type');
        $this->assertEmpty($emptyResult);
    }

    public function testGetFunctionClass(): void
    {
        $this->assertSame(JsonExtract::class, $this->service->getFunctionClass('JSON_EXTRACT'));
        $this->assertSame(Day::class, $this->service->getFunctionClass('DAY'));
        $this->assertSame(Sin::class, $this->service->getFunctionClass('sin'));
        $this->assertNull($this->service->getFunctionClass('NONEXISTENT'));
    }

    public function testGetFunctionType(): void
    {
        $this->assertSame(FunctionRegistryService::FUNCTION_TYPE_STRING, $this->service->getFunctionType('JSON_EXTRACT'));
        $this->assertSame(FunctionRegistryService::FUNCTION_TYPE_DATETIME, $this->service->getFunctionType('DAY'));
        $this->assertSame(FunctionRegistryService::FUNCTION_TYPE_NUMERIC, $this->service->getFunctionType('sin'));
        $this->assertNull($this->service->getFunctionType('NONEXISTENT'));
    }

    public function testGetAllFunctionNames(): void
    {
        $allNames = $this->service->getAllFunctionNames();

        $this->assertIsArray($allNames);
        $this->assertContains('JSON_EXTRACT', $allNames);
        $this->assertContains('DAY', $allNames);
        $this->assertContains('sin', $allNames);
        $this->assertGreaterThan(30, count($allNames));
    }

    public function testGetFunctionCount(): void
    {
        $count = $this->service->getFunctionCount();
        $this->assertIsInt($count);
        $this->assertGreaterThan(30, $count);
    }

    public function testSearchFunctions(): void
    {
        $jsonFunctions = $this->service->searchFunctions('json');
        $this->assertNotEmpty($jsonFunctions);

        foreach ($jsonFunctions as $function) {
            $this->assertArrayHasKey('name', $function);
            $this->assertArrayHasKey('type', $function);
            $this->assertArrayHasKey('class', $function);
            $this->assertStringContainsStringIgnoringCase('json', $function['name']);
        }

        $nonExistentSearch = $this->service->searchFunctions('nonexistent_pattern');
        $this->assertEmpty($nonExistentSearch);

        $dayFunctions = $this->service->searchFunctions('day');
        $functionNames = array_column($dayFunctions, 'name');
        $this->assertContains('DAY', $functionNames);
        $this->assertContains('WEEKDAY', $functionNames);
    }

    public function testSearchFunctionsCaseInsensitive(): void
    {
        $upperCaseSearch = $this->service->searchFunctions('JSON');
        $lowerCaseSearch = $this->service->searchFunctions('json');
        $mixedCaseSearch = $this->service->searchFunctions('Json');

        $this->assertSameSize($upperCaseSearch, $lowerCaseSearch);
        $this->assertSameSize($lowerCaseSearch, $mixedCaseSearch);

        $this->assertNotEmpty($upperCaseSearch);
        $this->assertContains('JSON_EXTRACT', array_column($upperCaseSearch, 'name'));
    }
}
