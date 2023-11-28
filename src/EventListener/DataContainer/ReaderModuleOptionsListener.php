<?php

declare(strict_types=1);

namespace Cgoit\CmaceBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

#[AsCallback(table: 'tl_content', target: 'fields.cal_readerModule.options')]
class ReaderModuleOptionsListener
{
    public function __construct(private readonly Connection $db)
    {
    }

    /**
     * @return array<mixed>
     *
     * @throws Exception
     */
    public function __invoke(DataContainer|null $dc = null): array
    {
        $arrModules = [];
        $objModules = $this->db->executeQuery("SELECT m.id, m.name, t.name AS theme FROM tl_module m LEFT JOIN tl_theme t ON m.pid=t.id WHERE m.type='eventreader' ORDER BY t.name, m.name");

        while ($arrRow = $objModules->fetchAssociative()) {
            $arrModules[$arrRow['theme']][$arrRow['id']] = $arrRow['name'].' (ID '.$arrRow['id'].')';
        }

        return $arrModules;
    }
}
