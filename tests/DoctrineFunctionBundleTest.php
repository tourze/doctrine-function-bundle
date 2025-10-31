<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\DoctrineFunctionBundle\DoctrineFunctionBundle;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;

/**
 * @internal
 */
#[CoversClass(DoctrineFunctionBundle::class)]
#[RunTestsInSeparateProcesses]
final class DoctrineFunctionBundleTest extends AbstractBundleTestCase
{
}
