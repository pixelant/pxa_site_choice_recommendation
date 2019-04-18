<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\ViewHelpers;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class ChoiceFlagViewHelper
 * @package Pixelant\PxaSiteChoiceRecommendation\ViewHelpers
 */
class ChoiceFlagViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'img';

    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * Register arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('flag', 'string', 'Choice flag', true);
        $this->registerArgument('paths', 'array', 'Array of flag icons path', false, ['EXT:core/Resources/Public/Icons/Flags/']);
        $this->registerArgument('allowedExtensions', 'string', 'List of allowed extension', false, 'svg,png');
        $this->registerArgument('width', 'int', 'Tag image width', false);
        $this->registerArgument('height', 'int', 'Tag image height', false);
    }

    /**
     * @param ImageService $imageService
     */
    public function injectImageService(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Render flag image
     *
     * @return string
     */
    public function render()
    {
        $image = $this->getImage();

        if ($image !== null) {
            $this->tag->addAttribute('src', $this->imageService->getImageUri($image));
            $this->tag->addAttribute('alt', $this->arguments['flag']);
            if ($this->arguments['width']) {
                $this->tag->addAttribute('width', (int)$this->arguments['width']);
            }
            if ($this->arguments['height']) {
                $this->tag->addAttribute('height', (int)$this->arguments['height']);
            }

            return $this->tag->render();
        }

        return '';
    }

    /**
     * Find image file
     *
     * @return File|null
     */
    protected function getImage(): ?File
    {
        $flag = $this->arguments['flag'];
        $paths = array_reverse($this->arguments['paths']);
        $allowedExt = GeneralUtility::trimExplode(',', $this->arguments['allowedExtensions'], true);

        foreach ($paths as $path) {
            $path = rtrim($path, '/') . '/';

            // Generate all possible file names, for all given paths and allowed extension and lower/upper case
            $possibleFileNames = [];
            foreach ($allowedExt as $extension) {
                $possibleFileNames[] = $path . strtolower($flag) . '.' . $extension;
                $possibleFileNames[] = $path . strtoupper($flag) . '.' . $extension;
            }

            foreach ($possibleFileNames as $fileName) {
                try {
                    return $this->imageService->getImage($fileName, null, false);
                } catch (\InvalidArgumentException $exception) {
                    continue;
                }
            }
        }

        return null;
    }
}
