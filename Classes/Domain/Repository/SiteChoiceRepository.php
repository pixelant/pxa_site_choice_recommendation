<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\Repository;

use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\SiteChoice;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class SiteChoiceRepository
 * @package Pixelant\PxaSiteChoiceRecommendation\Domain\Repository
 */
class SiteChoiceRepository extends Repository
{
    /**
     * Initialize with default query settings
     */
    public function initializeObject()
    {
        $defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(false);

        $this->setDefaultQuerySettings($defaultQuerySettings);
    }

    /**
     * Get root page site configuration
     *
     * @param int $rootPageUid
     * @return SiteChoice|object
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findOneByRootPage(int $rootPageUid)
    {
        $query = $this->createQuery();

        $query->matching(
            $query->contains('rootPages', $rootPageUid)
        );

        return $query->execute()->getFirst();
    }
}
