<?php

namespace StudioMitte\Urlguard2\Xclass;

use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class ContentObjectRenderer10Xclassed extends ContentObjectRenderer {


    /**
     * Gets the query arguments and assembles them for URLs.
     * Arguments may be removed or set, depending on configuration.
     *
     * @param array $conf Configuration
     * @param array $overruleQueryArguments Multidimensional key/value pairs that overrule incoming query arguments
     * @param bool $forceOverruleArguments If set, key/value pairs not in the query but the overrule array will be set
     * @return string The URL query part (starting with a &)
     */
    public function getQueryArguments($conf, $overruleQueryArguments = [], $forceOverruleArguments = false)
    {
        $exclude = [];
        $method = (string)($conf['method'] ?? '');
        if ($method === 'POST') {
            trigger_error('Assigning typolink.addQueryString.method = POST is not supported anymore since TYPO3 v10.0.', E_USER_WARNING);
            return '';
        }
        if ($method === 'GET,POST' || $method === 'POST,GET') {
            trigger_error('Assigning typolink.addQueryString.method = GET,POST or POST,GET is not supported anymore since TYPO3 v10.0 - falling back to GET.', E_USER_WARNING);
            $method = 'GET';
        }
        if ($method === 'GET') {
            $currentQueryArray = GeneralUtility::_GET();
        } else {
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