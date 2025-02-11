<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

namespace Cgoit\CmaceBundle\EventListener\DataContainer;

use Contao\Backend;
use Contao\BackendUser;
use Contao\CalendarBundle\Security\ContaoCalendarPermissions;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\System;

#[AsCallback(table: 'tl_content', target: 'fields.cal_calendar.options')]
class ContentCalendarOptionsListener extends Backend
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
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        if (!$this->User->isAdmin && !\is_array($this->User->calendars)) {
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
