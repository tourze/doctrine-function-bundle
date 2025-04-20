# Doctrine Function Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)

用于在 Symfony 应用中注册自定义 Doctrine SQL 函数的 Bundle。

## 功能特性

- 自动为 Doctrine ORM 注册自定义 SQL 函数
- 支持多种函数类型：
  - 字符串函数 (JSON_EXTRACT, ANY_VALUE 等)
  - 日期时间函数 (DAY, MONTH, YEAR 等)
  - 数值函数 (ACOS, SIN, TAN 等)
- 零配置，即装即用
- 与 Doctrine ORM 无缝集成

## 安装

```bash
composer require tourze/doctrine-function-bundle
```

## 快速开始

1. 在你的 Symfony 应用中注册 Bundle：

```php
// config/bundles.php
return [
    // ...
    Tourze\DoctrineFunctionBundle\DoctrineFunctionBundle::class => ['all' => true],
];
```

2. 无需额外配置，所有函数已自动注册。

3. 在 DQL 查询中使用这些函数：

```php
$query = $entityManager->createQuery('
    SELECT e FROM AppBundle:Entity e 
    WHERE JSON_EXTRACT(e.data, "$.property") = :value
');
$query->setParameter('value', 'test');
```

## 测试

在项目根目录运行：

```bash
vendor/bin/phpunit -c phpunit.xml packages/doctrine-function-bundle/tests
```

## 许可

MIT 许可证。详情请查看 [License File](LICENSE)。
