<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Detector;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class IpLanguageDetector
 * @package Pixelant\PxaSiteChoiceRecommendation\Detector
 */
class IpDetector implements DetectorInterface
{
    /**
     * GeoIp2 reader
     *
     * @var Reader
     */
    protected $reader = null;

    /**
     * @var float
     */
    protected $priority = 1.5;

    /**
     * IP address
     *
     * @var string
     */
    protected $ip = '';

    /**
     * Result of detect
     *
     * @var string
     */
    protected $countryIsoCode = null;

    /**
     * Initialize
     *
     * @param string $ip
     * @param string $dbPath
     */
    public function __construct(string $ip, string $dbPath)
    {
        $this->ip = $ip;
        $this->reader = GeneralUtility::makeInstance(Reader::class, $dbPath);
    }

    /**
     * Detect count ISO code by IP
     *
     * @return array
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function detect(): ?array
    {
        if ($this->countryIsoCode === null) {
            try {
                $record = $this->reader->country($this->ip);
                $this->countryIsoCode = strtolower($record->country->isoCode);
            } catch (AddressNotFoundException $exception) {
                return null;
            }
        }

        // Return ISO with priority
        return [
            $this->countryIsoCode => $this->priority
        ];
    }
}
