<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle.
 *
 * (c) Carsten Götzinger
 *
 * @license LGPL-3.0-or-later
 */

namespace Cgoit\CmaceBundle\Tests;

use Cgoit\CmaceBundle\ContaoCmaceBundle;
use PHPUnit\Framework\TestCase;

class ContaoCmaceBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new ContaoCmaceBundle();

        $this->assertInstanceOf('Cgoit\CmaceBundle\ContaoCmaceBundle', $bundle);
    }
}
