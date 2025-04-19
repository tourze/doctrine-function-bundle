<?php

namespace Tourze\DoctrineFunctionBundle\DependencyInjection;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\IdGeneratorPass;
use DoctrineExtensions\Query\Mysql\Acos;
use DoctrineExtensions\Query\Mysql\Asin;
use DoctrineExtensions\Query\Mysql\Atan;
use DoctrineExtensions\Query\Mysql\Atan2;
use DoctrineExtensions\Query\Mysql\BitCount;
use DoctrineExtensions\Query\Mysql\BitXor;
use DoctrineExtensions\Query\Mysql\Ceil;
use DoctrineExtensions\Query\Mysql\Cos;
use DoctrineExtensions\Query\Mysql\Cot;
use DoctrineExtensions\Query\Mysql\Degrees;
use DoctrineExtensions\Query\Mysql\Exp;
use DoctrineExtensions\Query\Mysql\Floor;
use DoctrineExtensions\Query\Mysql\JsonDepth;
use DoctrineExtensions\Query\Mysql\JsonLength;
use DoctrineExtensions\Query\Mysql\Log;
use DoctrineExtensions\Query\Mysql\Log10;
use DoctrineExtensions\Query\Mysql\Log2;
use DoctrineExtensions\Query\Mysql\Pi;
use DoctrineExtensions\Query\Mysql\Power;
use DoctrineExtensions\Query\Mysql\Quarter;
use DoctrineExtensions\Query\Mysql\Radians;
use DoctrineExtensions\Query\Mysql\Rand;
use DoctrineExtensions\Query\Mysql\Round;
use DoctrineExtensions\Query\Mysql\Sin;
use DoctrineExtensions\Query\Mysql\Std;
use DoctrineExtensions\Query\Mysql\StdDev;
use DoctrineExtensions\Query\Mysql\Tan;
use DoctrineExtensions\Query\Mysql\Variance;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Day;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Hour;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Minute;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Month;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Week;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\WeekDay;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Year;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonArray;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonContains;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonExtract;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonSearch;
use Tourze\DoctrineFunctionCollection\StringFunction\AnyValue;
use Tourze\DoctrineFunctionCollection\StringFunction\DateDiff;
use Tourze\DoctrineFunctionCollection\StringFunction\Field;
use Tourze\DoctrineFunctionCollection\StringFunction\FindInSet;
use Tourze\DoctrineFunctionCollection\StringFunction\IfElse;

class ORMConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $serviceIds = array_keys($container->findTaggedServiceIds(IdGeneratorPass::CONFIGURATION_TAG));
        foreach ($serviceIds as $serviceId) {
            $ormConfigDef = $container->getDefinition($serviceId);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['JSON_EXTRACT', JsonExtract::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['JSON_SEARCH', JsonSearch::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['JSON_ARRAY', JsonArray::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['JSON_CONTAINS', JsonContains::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['JSON_LENGTH', \Tourze\DoctrineFunctionCollection\JsonFunction\JsonLength::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['ANY_VALUE', AnyValue::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['FIELD', Field::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['FIND_IN_SET', FindInSet::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['IFELSE', IfElse::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['DATEDIFF', DateDiff::class]);
            $ormConfigDef->addMethodCall('addCustomStringFunction', ['RAND', \Tourze\DoctrineFunctionCollection\StringFunction\Rand::class]);

            $ormConfigDef->addMethodCall('addCustomDatetimeFunction', ['DAY', Day::class]);
            $ormConfigDef->addMethodCall('addCustomDatetimeFunction', ['HOUR', Hour::class]);
            $ormConfigDef->addMethodCall('addCustomDatetimeFunction', ['MINUTE', Minute::class]);
            $ormConfigDef->addMethodCall('addCustomDatetimeFunction', ['MONTH', Month::class]);
            $ormConfigDef->addMethodCall('addCustomDatetimeFunction', ['WEEK', Week::class]);
            $ormConfigDef->addMethodCall('addCustomDatetimeFunction', ['WEEKDAY', WeekDay::class]);
            $ormConfigDef->addMethodCall('addCustomDatetimeFunction', ['YEAR', Year::class]);

            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['acos', Acos::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['asin', Asin::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['atan2', Atan2::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['atan', Atan::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['bit_count', BitCount::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['bit_xor', BitXor::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['ceil', Ceil::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['cos', Cos::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['cot', Cot::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['degrees', Degrees::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['exp', Exp::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['floor', Floor::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['json_contains', \DoctrineExtensions\Query\Mysql\JsonContains::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['json_depth', JsonDepth::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['json_length', JsonLength::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['log', Log::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['log10', Log10::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['log2', Log2::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['pi', Pi::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['power', Power::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['quarter', Quarter::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['radians', Radians::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['rand', Rand::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['round', Round::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['stddev', StdDev::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['sin', Sin::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['std', Std::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['tan', Tan::class]);
            $ormConfigDef->addMethodCall('addCustomNumericFunction', ['variance', Variance::class]);
        }
    }
}
