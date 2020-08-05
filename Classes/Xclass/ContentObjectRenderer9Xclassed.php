<?php

namespace StudioMitte\Urlguard2\Xclass;

use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class ContentObjectRenderer9Xclassed extends ContentObjectRenderer {

    public function getQueryArguments($conf, $overruleQueryArguments = [], $forceOverruleArguments = false)
    {
        $method = (string)($conf['method'] ?? '');
        switch ($method) {
            case 'GET':
                $currentQueryArray = GeneralUtility::_GET();
                break;
            case 'POST':
                $currentQueryArray = GeneralUtility::_POST();
                break;
            case 'GET,POST':
                $currentQueryArray = GeneralUtility::_GET();
                ArrayUtility::mergeRecursiveWithOverrule($currentQueryArray, GeneralUtility::_POST());
                break;
            case 'POST,GET':
                $currentQueryArray = GeneralUtility::_POST();
                ArrayUtility::mergeRecursiveWithOverrule($currentQueryArray, GeneralUtility::_GET());
                break;
            default:
                $currentQueryArray = [];
                parse_str($this->getEnvironmentVariable('QUERY_STRING'), $currentQueryArray);
        }
        if ($conf['exclude'] ?? false) {
            $excludeString = str_replace(',', '&', $conf['exclude']);
            $excludedQueryParts = [];
            parse_str($excludeString, $excludedQueryParts);
            // never repeat id
            $exclude['id'] = 0;
            $newQueryArray = ArrayUtility::arrayDiffAssocRecursive($currentQueryArray, $excludedQueryParts);
        } else {
            $newQueryArray = $currentQueryArray;
        }
        ArrayUtility::mergeRecursiveWithOverrule($newQueryArray, $overruleQueryArguments, $forceOverruleArguments);

        // xclass
        $request = $GLOBALS['TYPO3_REQUEST'];
        if ($request) {
            /** @var PageArguments $pageArguments */
            $pageArguments = $request->getAttribute('routing');
            if ($pageArguments instanceof PageArguments) {
                $newQueryArray = array_intersect($pageArguments->getRouteArguments(), $newQueryArray);
            }
        }
        // end xclass

        return HttpUtility::buildQueryString($newQueryArray, '&');
    }
}