# Doctrine Function Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)

A Symfony bundle for registering custom Doctrine SQL functions.

## Features

- Automatically registers custom SQL functions for Doctrine ORM
- Supports multiple function types:
  - String functions (JSON_EXTRACT, ANY_VALUE, etc.)
  - Datetime functions (DAY, MONTH, YEAR, etc.)
  - Numeric functions (ACOS, SIN, TAN, etc.)
- Zero configuration required
- Integrates with Doctrine ORM

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

2. No additional configuration needed - all functions are automatically registered.

3. Use the functions in your DQL queries:

```php
$query = $entityManager->createQuery('
    SELECT e FROM AppBundle:Entity e 
    WHERE JSON_EXTRACT(e.data, "$.property") = :value
');
$query->setParameter('value', 'test');
```

## Testing

Run PHPUnit from the project root:

```bash
vendor/bin/phpunit -c phpunit.xml packages/doctrine-function-bundle/tests
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
