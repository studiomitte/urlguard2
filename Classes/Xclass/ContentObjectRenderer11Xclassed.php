<?php

namespace StudioMitte\Urlguard2\Xclass;

use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class ContentObjectRenderer11Xclassed extends ContentObjectRenderer
{

    /**
     * Gets the query arguments and assembles them for URLs.
     * Arguments may be removed or set, depending on configuration.
     *
     * @param array $conf Configuration
     * @return string The URL query part (starting with a &)
     */
    public function getQueryArguments($conf)
    {
        $currentQueryArray = GeneralUtility::_GET();
        if ($conf['exclude'] ?? false) {
            $excludeString = str_replace(',', '&', $conf['exclude']);
            $excludedQueryParts = [];
            parse_str($excludeString, $excludedQueryParts);
            $newQueryArray = ArrayUtility::arrayDiffKeyRecursive($currentQueryArray, $excludedQueryParts);
        } else {
            $newQueryArray = $currentQueryArray;
        }

        // xclass start
        $request = $GLOBALS['TYPO3_REQUEST'];
        if ($request) {
            /** @var PageArguments $pageArguments */
            $pageArguments = $request->getAttribute('routing');
            if ($pageArguments instanceof PageArguments) {
                $newQueryArray = ArrayUtility::intersectRecursive($pageArguments->getRouteArguments(), $newQueryArray);
            }
        }
        // xclass end
        return HttpUtility::buildQueryString($newQueryArray, '&');
    }
}
