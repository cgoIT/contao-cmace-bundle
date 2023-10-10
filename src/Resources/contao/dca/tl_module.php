<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle.
 *
 * (c) Carsten Götzinger
 *
 * @license LGPL-3.0-or-later
 */

use Contao\Backend;
use Contao\BackendUser;
use Contao\CalendarBundle\Security\ContaoCalendarPermissions;
use Contao\System;

$GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist_fixed_range'] = '{title_legend},name,headline,type;{config_legend},cmaceText,cal_calendar,cal_noSpan,cal_featured,cal_order,cal_readerModule,cal_limit,perPage,cal_hideRunning,cmaceEventsHeadline,cmaceEventsFrom,cmaceEventsUntil;{template_legend:hide},cal_template,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['fields'] = array_merge(
    ['cmaceText' => [
        'exclude' => true,
        'search' => true,
        'inputType' => 'textarea',
        'eval' => ['mandatory' => false, 'rte' => 'tinyMCE', 'tl_class' => 'w100'],
        'explanation' => 'insertTags',
        'sql' => 'mediumtext NULL',
    ]],
    ['cmaceEventsHeadline' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['cmaceEventsHeadline'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'inputUnit',
        'options' => ['h3', 'h4', 'h5', 'h6'],
        'eval' => ['maxlength' => 200, 'tl_class' => 'w50 clr'],
        'sql' => "varchar(255) NOT NULL default 'a:2:{s:5:\"value\";s:0:\"\";s:4:\"unit\";s:2:\"h3\";}'",
    ]],
    ['cmaceEventsFrom' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['cmaceEventsFrom'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'text',
        'eval' => ['mandatory' => true, 'rgxp' => 'date', 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'clr w50'],
        'sql' => 'bigint(20) NULL',
    ]],
    ['cmaceEventsUntil' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['cmaceEventsUntil'],
        'exclude' => true,
        'search' => true,
        'inputType' => 'text',
        'eval' => ['mandatory' => true, 'rgxp' => 'date', 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'w50'],
        'sql' => 'bigint(20) NULL',
    ]],
    $GLOBALS['TL_DCA']['tl_module']['fields']
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_module_cmace extends Backend
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
