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

use Cgoit\CmaceBundle\CgoitCmaceBundle;
use PHPUnit\Framework\TestCase;

class CgoitCmaceBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new CgoitCmaceBundle();

        $this->assertInstanceOf('Cgoit\CmaceBundle\CgoitCmaceBundle', $bundle);
    }
}
