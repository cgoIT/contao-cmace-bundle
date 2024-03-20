<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/*
 * Extend palettes
 */
PaletteManipulator::create()
    ->addLegend('news_legend', 'enclosure_legend', PaletteManipulator::POSITION_AFTER)
    ->addField('news', 'news_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_calendar_events')
;

/*
 * Table tl_calendar_events
 */
$GLOBALS['TL_DCA']['tl_calendar_events']['fields'] = array_merge(
    ['news' => [
        'label' => &$GLOBALS['TL_LANG']['tl_calendar_events']['news'],
        'inputType' => 'picker',
        'filter' => false,
        'exclude' => true,
        'search' => false,
        'relation' => ['type' => 'hasOne', 'load' => 'lazy', 'table' => 'tl_news'],
        'eval' => ['mandatory' => false, 'tl_class' => 'clr w50'],
        'sql' => 'int(10) unsigned NOT NULL default 0',
    ]],
    $GLOBALS['TL_DCA']['tl_calendar_events']['fields'] ?? [],
);
