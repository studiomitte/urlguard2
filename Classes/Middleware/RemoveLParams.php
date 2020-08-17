<?php

declare(strict_types=1);


namespace StudioMitte\Urlguard2\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Routing\SiteRouteResult;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;

/**
 * Remove L parameter
 */
class RemoveLParams implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // no value kills the query param
        if (($request->getQueryParams()['L']) ?? false) {
            $request = $request->withQueryParams(['L']);
        }
        return $handler->handle($request);
    }
}
