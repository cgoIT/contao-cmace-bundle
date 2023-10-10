<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle.
 *
 * (c) Carsten Götzinger
 *
 * @license LGPL-3.0-or-later
 */

namespace Cgoit\CmaceBundle\Controller;

use Contao\CalendarEventsModel;
use Contao\ContentModel;
use Contao\Date;
use Contao\ModuleModel;
use Contao\StringUtil;
use Contao\System;
use Contao\Template;

trait FixedTimeRangeContentAndModuleTrait
{
    protected function addEvents(Template $template, ContentModel|ModuleModel $model): void
    {
        if (!empty($model->headline)) {
            $arrHeadline = StringUtil::deserialize($model->headline, true);
            $template->hl = $arrHeadline['unit'];
            $template->headline = $arrHeadline['value'];
        }

        $template->text = $model->text;

        if (!empty($model->cmaceEventsHeadline)) {
            $arrEventsHeadline = StringUtil::deserialize($model->cmaceEventsHeadline, true);
            $template->entriesHl = $arrEventsHeadline['unit'];
            $template->entriesHeadline = $arrEventsHeadline['value'];
        }

        $arrEntries = [];

        $arrFields = [];
        $arrValues = [];

        if (!empty($model->cmaceEvents)) {
            $arrFields[] = 'id IN ('.implode(',', StringUtil::deserialize($model->cmaceEvents, true)).')';
        }

        if (!empty($model->cmaceEventsFrom)) {
            $arrFields[] = 'startDate>=?';
            $arrValues[] = $model->cmaceEventsFrom;
        }

        if (!empty($model->cmaceEventsUntil)) {
            $arrFields[] = 'startDate<=?';
            $arrValues[] = $model->cmaceEventsUntil;
        }

        if (!empty($model->cmaceCalendars)) {
            $arrFields[] = 'pid IN ('.implode(',', StringUtil::deserialize($model->cmaceCalendars, true)).')';
        }

        if (!empty($arrFields)) {
            $arrEvents = CalendarEventsModel::findBy(
                $arrFields,
                $arrValues,
                ['order' => 'startDate ASC']
            );

            if (null !== $arrEvents) {
                foreach ($arrEvents as $objEvent) {
                    $dateStr = Date::parse('l, d.m.Y', $objEvent->startDate);

                    if (!isset($arrEntries[$dateStr])) {
                        $arrEntries[$dateStr] = [];
                    }

                    $entry = $objEvent;

                    if (
                        !empty($GLOBALS['TL_HOOKS']['getFixedRangeEventsEntryHook'])
                        && \is_array($GLOBALS['TL_HOOKS']['getFixedRangeEventsEntryHook'])
                    ) {
                        foreach ($GLOBALS['TL_HOOKS']['getFixedRangeEventsEntryHook'] as $callback) {
                            $entry = System::importStatic($callback[0])->{$callback[1]}();
                        }
                    }

                    if ($entry) {
                        $arrEntries[$dateStr][] = $entry;
                    }
                }
            }
        }

        $template->entries = $arrEntries;
    }
}
