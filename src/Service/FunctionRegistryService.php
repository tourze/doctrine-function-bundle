<?php

namespace Tourze\DoctrineFunctionBundle\Service;

use Tourze\DoctrineFunctionBundle\Registry\FunctionRegistry;

readonly class FunctionRegistryService
{
    public const FUNCTION_TYPE_STRING = FunctionRegistry::TYPE_STRING;
    public const FUNCTION_TYPE_DATETIME = FunctionRegistry::TYPE_DATETIME;
    public const FUNCTION_TYPE_NUMERIC = FunctionRegistry::TYPE_NUMERIC;

    /**
     * @return array<string, array<string, class-string>>
     */
    public function getRegisteredFunctions(): array
    {
        return FunctionRegistry::getAllFunctions();
    }

    public function isFunctionRegistered(string $name): bool
    {
        return null !== $this->getFunctionClass($name);
    }

    /**
     * @return array<string, class-string>
     */
    public function getFunctionsByType(string $type): array
    {
        return match ($type) {
            self::FUNCTION_TYPE_STRING => FunctionRegistry::getStringFunctions(),
            self::FUNCTION_TYPE_DATETIME => FunctionRegistry::getDatetimeFunctions(),
            self::FUNCTION_TYPE_NUMERIC => FunctionRegistry::getNumericFunctions(),
            default => [],
        };
    }

    public function getFunctionClass(string $name): ?string
    {
        return FunctionRegistry::getStringFunctions()[$name] ??
               FunctionRegistry::getDatetimeFunctions()[$name] ??
               FunctionRegistry::getNumericFunctions()[$name] ??
               null;
    }

    public function getFunctionType(string $name): ?string
    {
        if (isset(FunctionRegistry::getStringFunctions()[$name])) {
            return self::FUNCTION_TYPE_STRING;
        }

        if (isset(FunctionRegistry::getDatetimeFunctions()[$name])) {
            return self::FUNCTION_TYPE_DATETIME;
        }

        if (isset(FunctionRegistry::getNumericFunctions()[$name])) {
            return self::FUNCTION_TYPE_NUMERIC;
        }

        return null;
    }

    /**
     * @return array<string>
     */
    public function getAllFunctionNames(): array
    {
        return array_merge(
            array_keys(FunctionRegistry::getStringFunctions()),
            array_keys(FunctionRegistry::getDatetimeFunctions()),
            array_keys(FunctionRegistry::getNumericFunctions())
        );
    }

    public function getFunctionCount(): int
    {
        return count(FunctionRegistry::getStringFunctions()) +
               count(FunctionRegistry::getDatetimeFunctions()) +
               count(FunctionRegistry::getNumericFunctions());
    }

    /**
     * @return array<array{name: string, type: string, class: class-string}>
     */
    public function searchFunctions(string $pattern): array
    {
        $pattern = strtolower($pattern);
        $result = [];

        foreach ($this->getRegisteredFunctions() as $type => $functions) {
            foreach ($functions as $name => $class) {
                if (str_contains(strtolower($name), $pattern)) {
                    $result[] = [
                        'name' => $name,
                        'type' => $type,
                        'class' => $class,
                    ];
                }
            }
        }

        return $result;
    }
}
