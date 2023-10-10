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
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\System;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(type: FixedTimeRangeElement::TYPE, category: 'calendar')]
class FixedTimeRangeElement extends AbstractContentElementController
{
    use FixedTimeRangeContentAndModuleTrait;

    public const TYPE = 'cal_fixed_time_range';

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response|null
    {
        System::loadLanguageFile('tl_content');
        $this->addEvents($template, $model);

        return $template->getResponse();
    }
}
