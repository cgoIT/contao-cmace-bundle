<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle.
 *
 * (c) Carsten Götzinger
 *
 * @license LGPL-3.0-or-later
 */

use Cgoit\CmaceBundle\Controller\ContentElement\FixedTimeRangeElement;
use Cgoit\CmaceBundle\Controller\Module\FixedTimeRangeModule;

$GLOBALS['TL_LANG']['CTE'][FixedTimeRangeElement::TYPE][0] = 'Eventliste (fixer Zeitraum)';
$GLOBALS['TL_LANG']['CTE'][FixedTimeRangeElement::TYPE][1] = 'Zeigt die Zusammenfassung mehrerer Events im Frontend an.';

$GLOBALS['TL_LANG']['FMD'][FixedTimeRangeModule::TYPE][0] = 'Eventliste (fixer Zeitraum)';
$GLOBALS['TL_LANG']['FMD'][FixedTimeRangeModule::TYPE][1] = 'Zeigt die Zusammenfassung mehrerer Events im Frontend an.';
