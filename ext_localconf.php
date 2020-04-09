<?php
defined('TYPO3_MODE') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class] = [
    'className' => \StudioMitte\Urlguard2\Xclass\ContentObjectRendererXclassed::class,
];