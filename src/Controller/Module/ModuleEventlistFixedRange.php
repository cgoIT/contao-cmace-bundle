<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle.
 *
 * (c) Carsten Götzinger
 *
 * @license LGPL-3.0-or-later
 */

namespace Cgoit\CmaceBundle\Controller\Module;

use Cgoit\CmaceBundle\Controller\FixedTimeRangeContentAndModuleTrait;
use Contao\ModuleEventlist;

/**
 * @property string|null $cmaceText
 * @property string|null $cmaceEventsHeadline
 * @property int         $cmaceEventsFrom
 * @property int         $cmaceEventsUntil
 */
class ModuleEventlistFixedRange extends ModuleEventlist
{
    use FixedTimeRangeContentAndModuleTrait;

    protected $strTemplate = 'mod_eventlist_fixedrange';

    public function generate(): string
    {
        $this->strTemplate = $this->customTpl ?: $this->strTemplate;

        return parent::generate();
    }
}
