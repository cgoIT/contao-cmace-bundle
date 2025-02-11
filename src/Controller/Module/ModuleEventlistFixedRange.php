<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-cmace-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

namespace Cgoit\CmaceBundle\Controller\Module;

use Cgoit\CmaceBundle\Controller\FixedTimeRangeContentAndModuleTrait;
use Contao\BackendTemplate;
use Contao\ModuleEventlist;
use Contao\StringUtil;
use Contao\System;

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

        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['eventlist_fixed_range'][0].' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = StringUtil::specialcharsUrl(System::getContainer()->get('router')->generate('contao_backend', ['do' => 'themes', 'table' => 'tl_module', 'act' => 'edit', 'id' => $this->id]));

            return $objTemplate->parse();
        }

        return parent::generate();
    }
}
