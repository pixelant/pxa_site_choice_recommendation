<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\SignalSlot;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * Trait DispatcherTrait
 * @package Pixelant\PxaSiteChoiceRecommendation\SignalSlot
 */
trait DispatcherTrait
{
    /**
     * @var Dispatcher
     */
    protected $signalSlotDispatcher = null;

    /**
     * Emit signal
     *
     * @param string $className
     * @param string $signal
     * @param array $arguments
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    protected function emitSignal(string $className, string $signal, array $arguments): void
    {
        $this->getSignalSlotDispatcher()->dispatch(
            $className,
            $signal,
            $arguments
        );
    }

    /**
     * Get dispatcher
     *
     * @return Dispatcher
     */
    protected function getSignalSlotDispatcher(): Dispatcher
    {
        if ($this->signalSlotDispatcher === null) {
            $objectManager = property_exists($this, 'objectManager')
                ? $this->objectManager
                : GeneralUtility::makeInstance(ObjectManager::class);

            $this->signalSlotDispatcher = $objectManager->get(Dispatcher::class);
        }

        return $this->signalSlotDispatcher;
    }
}