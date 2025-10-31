# Doctrine Function Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![License](https://img.shields.io/packagist/l/tourze/doctrine-function-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-bundle)
[![Tests](https://img.shields.io/github/actions/workflow/status/tourze/php-monorepo/test.yml?branch=master&label=tests&style=flat-square)](https://github.com/tourze/php-monorepo/actions)
[![Code Coverage](https://img.shields.io/codecov/c/github/tourze/php-monorepo?style=flat-square)](https://codecov.io/gh/tourze/php-monorepo)

一个 Symfony Bundle，自动注册来自 beberlei/doctrineextensions 和 tourze/doctrine-function-collection 包的自定义 Doctrine SQL 函数。

## 功能特性

- **零配置**：自动注册 40+ 个自定义 SQL 函数
- **多种函数类型**：
  - 字符串函数 (JSON_EXTRACT, ANY_VALUE, FIELD, FIND_IN_SET 等)
  - 日期时间函数 (DAY, MONTH, YEAR, HOUR, MINUTE 等)
  - 数值函数 (ACOS, SIN, TAN, POWER, RAND 等)
  - JSON 函数 (JSON_ARRAY, JSON_CONTAINS, JSON_SEARCH 等)
- **Symfony 集成**：通过编译器传递与 Doctrine ORM 无缝集成
- **生产就绪**：经过全面测试和性能优化

## 系统要求

- PHP 8.1 或更高版本
- Symfony 6.4 或更高版本
- Doctrine ORM 3.0 或更高版本

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

2. 在 DQL 查询中使用这些函数：

```php
use Doctrine\ORM\EntityManagerInterface;

// JSON 函数
$query = $entityManager->createQuery('
    SELECT u FROM App\Entity\User u 
    WHERE JSON_EXTRACT(u.metadata, "$.role") = :role
');
$query->setParameter('role', 'admin');

// 字符串函数
$query = $entityManager->createQuery('
    SELECT p FROM App\Entity\Product p 
    WHERE FIND_IN_SET(:category, p.categories) > 0
');
$query->setParameter('category', 'electronics');

// 日期时间函数
$query = $entityManager->createQuery('
    SELECT o FROM App\Entity\Order o 
    WHERE YEAR(o.createTime) = :year AND MONTH(o.createTime) = :month
');
$query->setParameters(['year' => 2023, 'month' => 12]);

// 数值函数
$query = $entityManager->createQuery('
    SELECT p FROM App\Entity\Point p 
    WHERE POWER(p.x, 2) + POWER(p.y, 2) < :radius
');
$query->setParameter('radius', 100);
```

## 可用函数

### 字符串函数
- `JSON_EXTRACT` - 从 JSON 中提取数据
- `JSON_SEARCH` - 在 JSON 数据中搜索
- `JSON_ARRAY` - 创建 JSON 数组
- `JSON_CONTAINS` - 检查 JSON 是否包含值
- `JSON_LENGTH` - 获取 JSON 长度
- `ANY_VALUE` - 从组中获取任意值
- `FIELD` - 查找字段位置
- `FIND_IN_SET` - 在逗号分隔列表中查找值
- `IFELSE` - 条件表达式
- `DATEDIFF` - 日期差
- `RAND` - 随机字符串值

### 日期时间函数
- `DAY` - 从日期中提取天
- `MONTH` - 从日期中提取月
- `YEAR` - 从日期中提取年
- `HOUR` - 从日期时间中提取小时
- `MINUTE` - 从日期时间中提取分钟
- `WEEK` - 从日期中提取周
- `WEEKDAY` - 从日期中提取星期几

### 数值函数
- `ACOS`, `ASIN`, `ATAN`, `ATAN2` - 三角函数
- `COS`, `SIN`, `TAN` - 三角函数
- `DEGREES`, `RADIANS` - 角度转换
- `EXP`, `LOG`, `LOG10`, `LOG2` - 对数函数
- `POWER`, `SQRT` - 幂函数
- `CEIL`, `FLOOR`, `ROUND` - 舍入函数
- `PI`, `RAND` - 数学常数和随机数
- `BIT_COUNT`, `BIT_XOR` - 位运算
- `STDDEV`, `VARIANCE` - 统计函数

## 测试

在项目根目录运行测试：

```bash
vendor/bin/phpunit packages/doctrine-function-bundle/tests
```

## 贡献

请查看 [CONTRIBUTING.md](CONTRIBUTING.md) 了解详情。

## 许可

MIT 许可证。详情请查看 [License File](LICENSE)。
