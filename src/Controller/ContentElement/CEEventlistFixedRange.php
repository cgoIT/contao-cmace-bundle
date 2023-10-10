<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle.
 *
 * (c) Carsten Götzinger
 *
 * @license LGPL-3.0-or-later
 */

namespace Cgoit\CmaceBundle\Controller\ContentElement;

use Cgoit\CmaceBundle\Controller\FixedTimeRangeContentAndModuleTrait;
use Contao\Config;
use Contao\FrontendTemplate;
use Contao\ModuleEventlist;
use Contao\StringUtil;
use Contao\System;

/**
 * @property bool        $cal_noSpan
 * @property string      $cal_template
 * @property int         $cal_limit
 * @property string      $cal_order
 * @property array       $cal_calendar
 * @property int         $cal_readerModule
 * @property bool        $cal_hideRunning
 * @property string      $cal_featured
 * @property string|null $text
 * @property string|null $cmaceEventsHeadline
 * @property int         $cmaceEventsFrom
 * @property int         $cmaceEventsUntil
 * @property bool        $invisible
 */
class CEEventlistFixedRange extends ModuleEventlist
{
    use FixedTimeRangeContentAndModuleTrait;

    protected $strTemplate = 'ce_eventlist_fixedrange';

    public function generate(): string
    {
        $this->strTemplate = $this->customTpl ?: $this->strTemplate;

        if ($this->invisible) {
            return '';
        }

        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $this->Template = new FrontendTemplate($this->strTemplate);
            $this->Template->setData($this->arrData);

            // Do not change this order (see #6191)
            $this->Template->style = !empty($this->arrStyle) ? implode(' ', $this->arrStyle) : '';
            $this->Template->class = trim('ce_'.$this->type.' '.($this->cssID[1] ?? ''));
            $this->Template->cssID = !empty($this->cssID[0]) ? ' id="'.$this->cssID[0].'"' : '';

            if (!$this->Template->headline) {
                $this->Template->headline = $this->headline;
            }

            if (!$this->Template->hl) {
                $this->Template->hl = $this->hl; // @phpstan-ignore-line
            }

            if (!empty($this->objModel->classes)) {
                $this->Template->class .= ' '.implode(' ', $this->objModel->classes);
            }

            return $this->Template->parse();
        }

        $this->cal_calendar = $this->sortOutProtected(StringUtil::deserialize($this->cal_calendar, true));

        // Return if there are no calendars
        if (empty($this->cal_calendar)) {
            return '';
        }

        // Show the event reader if an item has been selected
        if ($this->cal_readerModule > 0 && (isset($_GET['events']) || (Config::get('useAutoItem') && isset($_GET['auto_item'])))) {
            return $this->getFrontendModule($this->cal_readerModule, $this->strColumn);
        }

        $this->Template = new FrontendTemplate($this->strTemplate);
        $this->Template->setData($this->arrData);

        $this->compile();

        // Do not change this order (see #6191)
        $this->Template->style = !empty($this->arrStyle) ? implode(' ', $this->arrStyle) : '';
        $this->Template->class = trim('ce_'.$this->type.' '.($this->cssID[1] ?? ''));
        $this->Template->cssID = !empty($this->cssID[0]) ? ' id="'.$this->cssID[0].'"' : '';

        $this->Template->inColumn = $this->strColumn;

        if (!$this->Template->headline) {
            $this->Template->headline = $this->headline;
        }

        if (!$this->Template->hl) {
            $this->Template->hl = $this->hl; // @phpstan-ignore-line
        }

        if (!empty($this->objModel->classes)) {
            $this->Template->class .= ' '.implode(' ', $this->objModel->classes);
        }

        // Tag the content element (see #2137)
        if (null !== $this->objModel) {
            System::getContainer()->get('contao.cache.entity_tags')->tagWithModelInstance($this->objModel);
        }

        return $this->Template->parse();
    }
}
