<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\ViewHelpers;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class ChanksViewHelper
 * @package Pixelant\PxaSiteChoiceRecommendation\ViewHelpers
 */
class ChunksViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Register arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('items', 'mixed', 'Items', false, null);
        $this->registerArgument('size', 'int', 'Chunk size', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return array|mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $items = $arguments['items'] ?? $renderChildrenClosure();
        if (is_object($items) && ($items instanceof QueryResultInterface || $items instanceof ObjectStorage)) {
            $items = $items->toArray();
        }

        if (!is_array($items)) {
            throw new \InvalidArgumentException('$items expected to be array', 1555583137552);
        }

        $size = (int)$arguments['size'];
        if ($size > 0) {
            return array_chunk($items, $size);
        }

        return $items;
    }
}
