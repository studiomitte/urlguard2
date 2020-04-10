<?php
defined('TYPO3_MODE') or die();

$boot = static function () {
    $typo3version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);
    if ($typo3version->getMajorVersion() === 9) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
            'className' => \StudioMitte\Urlguard2\Xclass\ContentObjectRenderer9Xclassed::class,
        ];
    } else {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
            'className' => \StudioMitte\Urlguard2\Xclass\ContentObjectRenderer10Xclassed::class,
        ];
    }
};

$boot();
unset($boot);

