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
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\ModuleModel;
use Contao\System;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(type: FixedTimeRangeModule::TYPE, category: 'calendar')]
class FixedTimeRangeModule extends AbstractFrontendModuleController
{
    use FixedTimeRangeContentAndModuleTrait;

    public const TYPE = 'cal_fixed_time_range';

    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response|null
    {
        System::loadLanguageFile('tl_module');
        $this->addEvents($template, $model);

        return $template->getResponse();
    }
}
