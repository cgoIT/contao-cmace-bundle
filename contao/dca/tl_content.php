<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

use Contao\Controller;
use Contao\System;

System::loadLanguageFile('tl_module');

$GLOBALS['TL_DCA']['tl_content']['palettes']['eventlist_fixed_range'] = '{type_legend},type,headline;{cmace_legend},text,cal_calendar,cal_noSpan,cal_featured,cal_order,cal_readerModule,cal_limit,perPage,cal_hideRunning,cmaceEventsHeadline,cmaceEventsFrom,cmaceEventsUntil;{template_legend:hide},cal_template,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_content']['fields'] = array_merge(
    ['cmaceEventsHeadline' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cmaceEventsHeadline'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'inputUnit',
        'options' => ['h3', 'h4', 'h5', 'h6'],
        'eval' => ['maxlength' => 200, 'tl_class' => 'w50 clr'],
        'sql' => ['type' => 'text', 'length' => 1000, 'default' => 'a:2:{s:5:"value";s:0:"";s:4:"unit";s:2:"h3";}'],
    ]],
    ['cal_calendar' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cal_calendar'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'checkbox',
        'eval' => ['mandatory' => false, 'multiple' => true, 'tl_class' => 'w100'],
        'sql' => ['type' => 'blob', 'length' => 65535, 'notnull' => false],
    ]],
    ['cal_noSpan' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cal_noSpan'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'clr w50'],
        'sql' => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => ''],
    ]],
    ['cal_hideRunning' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cal_hideRunning'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50'],
        'sql' => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => ''],
    ]],
    ['cal_order' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cal_order'],
        'exclude' => true,
        'inputType' => 'select',
        'options' => ['ascending', 'descending'],
        'reference' => &$GLOBALS['TL_LANG']['MSC'],
        'eval' => ['tl_class' => 'w50'],
        'sql' => ['type' => 'string', 'length' => 16, 'default' => 'ascending'],
    ]],
    ['cal_readerModule' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cal_readerModule'],
        'exclude' => true,
        'inputType' => 'select',
        'reference' => &$GLOBALS['TL_LANG']['tl_module'],
        'eval' => ['includeBlankOption' => true, 'tl_class' => 'w50'],
        'sql' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'default' => 0],
    ]],
    ['cal_limit' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cal_limit'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['rgxp' => 'natural', 'tl_class' => 'w50'],
        'sql' => ['type' => 'smallint', 'length' => 5, 'unsigned' => true, 'default' => 0],
    ]],
    ['perPage' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['perPage'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['rgxp' => 'natural', 'tl_class' => 'w50'],
        'sql' => ['type' => 'smallint', 'length' => 5, 'unsigned' => true, 'default' => 0],
    ]],
    ['cal_template' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cal_template'],
        'exclude' => true,
        'inputType' => 'select',
        'options_callback' => static fn () => Controller::getTemplateGroup('event_'),
        'eval' => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
        'sql' => ['type' => 'string', 'length' => 256, 'default' => ''],
    ]],
    ['cal_featured' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cal_featured'],
        'exclude' => true,
        'inputType' => 'select',
        'options' => ['all_items', 'featured', 'unfeatured'],
        'reference' => &$GLOBALS['TL_LANG']['tl_module']['events'],
        'eval' => ['tl_class' => 'w50'],
        'sql' => ['type' => 'string', 'length' => 16, 'default' => 'all_items'],
    ]],
    ['cmaceEventsFrom' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cmaceEventsFrom'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'text',
        'eval' => ['rgxp' => 'date', 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'clr w50'],
        'sql' => ['type' => 'bigint', 'length' => 20, 'notnull' => false],
    ]],
    ['cmaceEventsUntil' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cmaceEventsUntil'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'text',
        'eval' => ['rgxp' => 'date', 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'w50'],
        'sql' => ['type' => 'bigint', 'length' => 20, 'notnull' => false],
    ]],
    ['cmaceEvents' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cmaceEvents'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'picker',
        'relation' => ['type' => 'hasMany', 'load' => 'lazy', 'table' => 'tl_calendar_events'],
        'eval' => ['mandatory' => false, 'multiple' => true, 'tl_class' => 'clr w50'],
        'sql' => ['type' => 'blob', 'length' => 65535, 'notnull' => false],
    ]],
    $GLOBALS['TL_DCA']['tl_content']['fields'],
);
