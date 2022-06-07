<?php
defined('TYPO3_MODE') or die();

$boot = static function () {
    if (class_exists(\TYPO3\CMS\Core\Information\Typo3Version::class)) {
        $typo3version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);
        $version = $typo3version->getMajorVersion();
    } else {
        $typo3VersionSplit = explode('.', TYPO3_branch);
        $version = (int)$typo3VersionSplit[0];
    }

    switch ($version) {
        case 9:
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
                'className' => \StudioMitte\Urlguard2\Xclass\ContentObjectRenderer9Xclassed::class,
            ];
            break;
        case 10:
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
                'className' => \StudioMitte\Urlguard2\Xclass\ContentObjectRenderer10Xclassed::class,
            ];
            break;
        case 11:
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
                'className' => \StudioMitte\Urlguard2\Xclass\ContentObjectRenderer11Xclassed::class,
            ];
    }
};

$boot();
unset($boot);
