# Doctrine Function Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![License](https://img.shields.io/packagist/l/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![Tests](https://img.shields.io/github/actions/workflow/status/tourze/php-monorepo/test.yml?branch=master&label=tests&style=flat-square)](https://github.com/tourze/php-monorepo/actions)
[![Code Coverage](https://img.shields.io/codecov/c/github/tourze/php-monorepo?style=flat-square)](https://codecov.io/gh/tourze/php-monorepo)

A Symfony bundle that automatically registers custom Doctrine SQL functions from beberlei/doctrineextensions and tourze/doctrine-function-collection packages.

## Features

- **Zero Configuration**: Automatically registers 40+ custom SQL functions
- **Multiple Function Types**:
  - String functions (JSON_EXTRACT, ANY_VALUE, FIELD, FIND_IN_SET, etc.)
  - Datetime functions (DAY, MONTH, YEAR, HOUR, MINUTE, etc.)
  - Numeric functions (ACOS, SIN, TAN, POWER, RAND, etc.)
  - JSON functions (JSON_ARRAY, JSON_CONTAINS, JSON_SEARCH, etc.)
- **Symfony Integration**: Seamlessly integrates with Doctrine ORM through compiler passes
- **Production Ready**: Fully tested and optimized for performance

## Requirements

- PHP 8.1 or higher
- Symfony 6.4 or higher
- Doctrine ORM 3.0 or higher

## Installation

```bash
composer require tourze/doctrine-function-bundle
```

## Quick Start

1. Register the bundle in your Symfony application:

```php
// config/bundles.php
return [
    // ...
    Tourze\DoctrineFunctionBundle\DoctrineFunctionBundle::class => ['all' => true],
];
```

2. Use the functions in your DQL queries:

```php
use Doctrine\ORM\EntityManagerInterface;

// JSON functions
$query = $entityManager->createQuery('
    SELECT u FROM App\Entity\User u 
    WHERE JSON_EXTRACT(u.metadata, "$.role") = :role
');
$query->setParameter('role', 'admin');

// String functions
$query = $entityManager->createQuery('
    SELECT p FROM App\Entity\Product p 
    WHERE FIND_IN_SET(:category, p.categories) > 0
');
$query->setParameter('category', 'electronics');

// Datetime functions
$query = $entityManager->createQuery('
    SELECT o FROM App\Entity\Order o 
    WHERE YEAR(o.createTime) = :year AND MONTH(o.createTime) = :month
');
$query->setParameters(['year' => 2023, 'month' => 12]);

// Numeric functions
$query = $entityManager->createQuery('
    SELECT p FROM App\Entity\Point p 
    WHERE POWER(p.x, 2) + POWER(p.y, 2) < :radius
');
$query->setParameter('radius', 100);
```

## Available Functions

### String Functions
- `JSON_EXTRACT` - Extract data from JSON
- `JSON_SEARCH` - Search within JSON data
- `JSON_ARRAY` - Create JSON arrays
- `JSON_CONTAINS` - Check if JSON contains value
- `JSON_LENGTH` - Get JSON length
- `ANY_VALUE` - Get any value from group
- `FIELD` - Find field position
- `FIND_IN_SET` - Find value in comma-separated list
- `IFELSE` - Conditional expression
- `DATEDIFF` - Date difference
- `RAND` - Random string value

### Datetime Functions
- `DAY` - Extract day from date
- `MONTH` - Extract month from date
- `YEAR` - Extract year from date
- `HOUR` - Extract hour from datetime
- `MINUTE` - Extract minute from datetime
- `WEEK` - Extract week from date
- `WEEKDAY` - Extract weekday from date

### Numeric Functions
- `ACOS`, `ASIN`, `ATAN`, `ATAN2` - Trigonometric functions
- `COS`, `SIN`, `TAN` - Trigonometric functions
- `DEGREES`, `RADIANS` - Angle conversion
- `EXP`, `LOG`, `LOG10`, `LOG2` - Logarithmic functions
- `POWER`, `SQRT` - Power functions
- `CEIL`, `FLOOR`, `ROUND` - Rounding functions
- `PI`, `RAND` - Mathematical constants and random
- `BIT_COUNT`, `BIT_XOR` - Bit operations
- `STDDEV`, `VARIANCE` - Statistical functions

## Testing

Run tests from the project root:

```bash
vendor/bin/phpunit packages/doctrine-function-bundle/tests
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
