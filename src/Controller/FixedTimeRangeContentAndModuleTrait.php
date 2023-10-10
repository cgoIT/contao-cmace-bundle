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

use Contao\Date;
use Contao\StringUtil;

trait FixedTimeRangeContentAndModuleTrait
{
    protected function compile(): void
    {
        $headline = $this->headline;

        parent::compile();

        $this->Template->headline = $headline ?: '';

        if (!empty($this->customTpl)) {
            $this->strTemplate = $this->customTpl;
        }

        $this->Template->text = $this->cmaceText ?: '';

        if (!empty($this->cmaceEventsHeadline)) {
            $arrEventsHeadline = StringUtil::deserialize($this->cmaceEventsHeadline, true);
            $this->Template->entriesHl = $arrEventsHeadline['unit'];
            $this->Template->entriesHeadline = $arrEventsHeadline['value'];
        }
    }

    /**
     * @param string $strFormat
     *
     * @return array<mixed>
     */
    protected function getDatesFromFormat(Date $objDate, $strFormat): array
    {
        $intStart = $this->cmaceEventsFrom;
        $intEnd = \DateTime::createFromFormat('Y-m-d H:i:s', (new \DateTime())->setTimestamp($this->cmaceEventsUntil)->format('Y-m-d 23:59:59'))->getTimestamp();

        return [$intStart, $intEnd, $GLOBALS['TL_LANG']['MSC']['cal_empty']];
    }
}
