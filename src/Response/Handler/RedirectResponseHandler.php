<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response\Handler;

use Basster\LazyResponseBundle\Response\LazyResponseInterface;
use Basster\LazyResponseBundle\Response\RedirectResponse;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RedirectResponseHandler.
 */
final class RedirectResponseHandler extends AbstractLazyResponseHandler
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    protected function isSupported(LazyResponseInterface $controllerResult): bool
    {
        return $controllerResult instanceof RedirectResponse;
    }

    /**
     * @param RedirectResponse $controllerResult
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    protected function generateResponse(LazyResponseInterface $controllerResult): Response
    {
        return new SymfonyRedirectResponse(
            $this->router->generate(
                $controllerResult->getRouteName(),
                $controllerResult->getRouteParams()
            ),
            $controllerResult->getStatusCode(),
            $controllerResult->getHeaders()
        );
    }
}
