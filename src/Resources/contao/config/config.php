<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle.
 *
 * (c) Carsten Götzinger
 *
 * @license LGPL-3.0-or-later
 */

use Cgoit\CmaceBundle\Controller\ContentElement\CEEventlistFixedRange;
use Cgoit\CmaceBundle\Controller\Module\ModuleEventlistFixedRange;

$GLOBALS['TL_CTE']['events'] = [];

/*
 * Content elements
 */
$GLOBALS['TL_CTE']['events'] = ['eventlist_fixed_range' => CEEventlistFixedRange::class];

// Front end modules
$GLOBALS['FE_MOD']['events']['eventlist_fixed_range'] = ModuleEventlistFixedRange::class;
