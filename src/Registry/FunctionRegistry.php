<?php

namespace Tourze\DoctrineFunctionBundle\Registry;

use DoctrineExtensions\Query\Mysql\Acos;
use DoctrineExtensions\Query\Mysql\Asin;
use DoctrineExtensions\Query\Mysql\Atan;
use DoctrineExtensions\Query\Mysql\Atan2;
use DoctrineExtensions\Query\Mysql\BitCount;
use DoctrineExtensions\Query\Mysql\BitXor;
use DoctrineExtensions\Query\Mysql\Ceil;
use DoctrineExtensions\Query\Mysql\Cos;
use DoctrineExtensions\Query\Mysql\Cot;
use DoctrineExtensions\Query\Mysql\DateAdd;
use DoctrineExtensions\Query\Mysql\DateFormat;
use DoctrineExtensions\Query\Mysql\DateSub;
use DoctrineExtensions\Query\Mysql\Degrees;
use DoctrineExtensions\Query\Mysql\Exp;
use DoctrineExtensions\Query\Mysql\Floor;
use DoctrineExtensions\Query\Mysql\JsonDepth;
use DoctrineExtensions\Query\Mysql\JsonLength;
use DoctrineExtensions\Query\Mysql\Log;
use DoctrineExtensions\Query\Mysql\Log10;
use DoctrineExtensions\Query\Mysql\Log2;
use DoctrineExtensions\Query\Mysql\Now;
use DoctrineExtensions\Query\Mysql\Pi;
use DoctrineExtensions\Query\Mysql\Power;
use DoctrineExtensions\Query\Mysql\Quarter;
use DoctrineExtensions\Query\Mysql\Radians;
use DoctrineExtensions\Query\Mysql\Rand;
use DoctrineExtensions\Query\Mysql\Round;
use DoctrineExtensions\Query\Mysql\Second;
use DoctrineExtensions\Query\Mysql\Sin;
use DoctrineExtensions\Query\Mysql\Std;
use DoctrineExtensions\Query\Mysql\StdDev;
use DoctrineExtensions\Query\Mysql\Tan;
use DoctrineExtensions\Query\Mysql\Time;
use DoctrineExtensions\Query\Mysql\TimestampDiff;
use DoctrineExtensions\Query\Mysql\Variance;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Date;
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

class FunctionRegistry
{
    public const TYPE_STRING = 'string';
    public const TYPE_DATETIME = 'datetime';
    public const TYPE_NUMERIC = 'numeric';

    /**
     * @return array<string, class-string>
     */
    public static function getStringFunctions(): array
    {
        return [
            'JSON_EXTRACT' => JsonExtract::class,
            'JSON_SEARCH' => JsonSearch::class,
            'JSON_ARRAY' => JsonArray::class,
            'JSON_CONTAINS' => JsonContains::class,
            'JSON_LENGTH' => \Tourze\DoctrineFunctionCollection\JsonFunction\JsonLength::class,
            'ANY_VALUE' => AnyValue::class,
            'FIELD' => Field::class,
            'FIND_IN_SET' => FindInSet::class,
            'IFELSE' => IfElse::class,
            'RAND' => \Tourze\DoctrineFunctionCollection\StringFunction\Rand::class,
        ];
    }

    /**
     * @return array<string, class-string>
     */
    public static function getDatetimeFunctions(): array
    {
        return [
            'DATE' => Date::class,
            'DAY' => Day::class,
            'HOUR' => Hour::class,
            'MINUTE' => Minute::class,
            'MONTH' => Month::class,
            'SECOND' => Second::class,
            'TIME' => Time::class,
            'WEEK' => Week::class,
            'WEEKDAY' => WeekDay::class,
            'YEAR' => Year::class,
            'NOW' => Now::class,
            'DATE_ADD' => DateAdd::class,
            'DATE_SUB' => DateSub::class,
            'DATE_FORMAT' => DateFormat::class,
            'TIMESTAMPDIFF' => TimestampDiff::class,
            'DATEDIFF' => DateDiff::class,
        ];
    }

    /**
     * @return array<string, class-string>
     */
    public static function getNumericFunctions(): array
    {
        return [
            'acos' => Acos::class,
            'asin' => Asin::class,
            'atan2' => Atan2::class,
            'atan' => Atan::class,
            'bit_count' => BitCount::class,
            'bit_xor' => BitXor::class,
            'ceil' => Ceil::class,
            'cos' => Cos::class,
            'cot' => Cot::class,
            'degrees' => Degrees::class,
            'exp' => Exp::class,
            'floor' => Floor::class,
            'json_contains' => \DoctrineExtensions\Query\Mysql\JsonContains::class,
            'json_depth' => JsonDepth::class,
            'json_length' => JsonLength::class,
            'log' => Log::class,
            'log10' => Log10::class,
            'log2' => Log2::class,
            'pi' => Pi::class,
            'power' => Power::class,
            'quarter' => Quarter::class,
            'radians' => Radians::class,
            'rand' => Rand::class,
            'round' => Round::class,
            'stddev' => StdDev::class,
            'sin' => Sin::class,
            'std' => Std::class,
            'tan' => Tan::class,
            'variance' => Variance::class,
        ];
    }

    /**
     * @return array<string, array<string, class-string>>
     */
    public static function getAllFunctions(): array
    {
        return [
            self::TYPE_STRING => self::getStringFunctions(),
            self::TYPE_DATETIME => self::getDatetimeFunctions(),
            self::TYPE_NUMERIC => self::getNumericFunctions(),
        ];
    }
}
