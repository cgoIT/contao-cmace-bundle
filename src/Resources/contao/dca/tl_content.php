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
use Contao\Backend;
use Contao\BackendUser;
use Contao\CalendarBundle\Security\ContaoCalendarPermissions;
use Contao\System;

$GLOBALS['TL_DCA']['tl_content']['palettes'][FixedTimeRangeElement::TYPE] = '{type_legend},type,headline;{cmace_legend},text,cmaceEventsHeadline,cmaceCalendars,cmaceEventsFrom,cmaceEventsUntil,cmaceEvents;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_content']['fields'] = array_merge(
    ['cmaceEventsHeadline' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cmaceEventsHeadline'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'inputUnit',
        'options' => ['h3', 'h4', 'h5', 'h6'],
        'eval' => ['maxlength' => 200, 'tl_class' => 'w50 clr'],
        'sql' => "varchar(255) NOT NULL default 'a:2:{s:5:\"value\";s:0:\"\";s:4:\"unit\";s:2:\"h3\";}'",
    ]],
    ['cmaceCalendars' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cmaceCalendars'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'checkbox',
        'options_callback' => ['tl_content_cmace', 'getCalendars'],
        'eval' => ['mandatory' => false, 'multiple' => true, 'tl_class' => 'clr w50'],
        'sql' => 'blob NULL',
    ]],
    ['cmaceEventsFrom' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cmaceEventsFrom'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'text',
        'eval' => ['rgxp' => 'date', 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'clr w50'],
        'sql' => 'bigint(20) NULL',
    ]],
    ['cmaceEventsUntil' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cmaceEventsUntil'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'text',
        'eval' => ['rgxp' => 'date', 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'w50'],
        'sql' => 'bigint(20) NULL',
    ]],
    ['cmaceEvents' => [
        'label' => &$GLOBALS['TL_LANG']['tl_content']['cmaceEvents'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'picker',
        'relation' => ['type' => 'hasMany', 'load' => 'lazy', 'table' => 'tl_calendar_events'],
        'eval' => ['mandatory' => false, 'multiple' => true, 'tl_class' => 'clr w50'],
        'sql' => 'blob NULL',
    ]],
    $GLOBALS['TL_DCA']['tl_content']['fields']
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_content_cmace extends Backend
{
    /**
     * Import the back end user object.
     */
    public function __construct()
    {
        parent::__construct();
        $this->import(BackendUser::class, 'User');
    }

    /**
     * Get all calendars and return them as array.
     *
     * @return array
     */
    public function getCalendars()
    {
        if (!$this->User->isAdmin && !is_array($this->User->calendars)) {
            return [];
        }

        $arrCalendars = [];
        $objCalendars = $this->Database->execute('SELECT id, title FROM tl_calendar ORDER BY title');
        $security = System::getContainer()->get('security.helper');

        while ($objCalendars->next()) {
            if ($security->isGranted(ContaoCalendarPermissions::USER_CAN_EDIT_CALENDAR, $objCalendars->id)) {
                $arrCalendars[$objCalendars->id] = $objCalendars->title;
            }
        }

        return $arrCalendars;
    }
}
