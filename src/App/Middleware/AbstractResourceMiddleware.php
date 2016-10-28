<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

namespace App\Middleware;

use App\Mapper\MapperException;
use App\Mapper\MapperInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Helper\UrlHelper;

/**
 * Class AbstractResourceMiddleware
 *
 * @package App\Middleware
 */
abstract class AbstractResourceMiddleware
{
    use RestDispatchTrait;

    /**
     * @var string
     */
    protected $resourceName;

    /**
     * @var string
     */
    protected $collectionName;

    /**
     * @var string
     */
    protected $routeName;

    /**
     * @var string
     */
    protected $routeIdentifier;

    /**
     * @var MapperInterface
     */
    protected $mapper;

    /**
     * @var UrlHelper
     */
    protected $helper;

    /**
     * @param string $resourceName
     * @return AbstractResourceMiddleware
     */
    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;
        return $this;
    }

    /**
     * @param string $collectionName
     * @return AbstractResourceMiddleware
     */
    public function setCollectionName($collectionName)
    {
        $this->collectionName = $collectionName;
        return $this;
    }

    /**
     * @param string $routeName
     * @return AbstractResourceMiddleware
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;
        return $this;
    }

    /**
     * @param string $routeIdentifier
     * @return AbstractResourceMiddleware
     */
    public function setRouteIdentifier($routeIdentifier)
    {
        $this->routeIdentifier = $routeIdentifier;
        return $this;
    }

    /**
     * Post constructor.
     * @param MapperInterface $mapper
     * @param UrlHelper $helper
     */
    public function __construct(MapperInterface $mapper, UrlHelper $helper)
    {
        $this->mapper = $mapper;
        $this->helper = $helper;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface|JsonResponse
     */
    public function get(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute($this->routeIdentifier);
        if (null === $id) {
            $collection = $this->mapper->fetchAll($request->getQueryParams());
            return new JsonResponse([$this->collectionName => $collection]);
        }
        $entity = $this->mapper->fetch($id);
        if (!$entity) {
            return $response->withStatus(404);
        }
        return new JsonResponse([$this->resourceName => $entity]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function post(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $data = $request->getParsedBody();
        try {
            $entity = $this->mapper->create($data);
            if (!isset($entity[$this->routeIdentifier])) {
                return $response->withStatus(520);
            } else {
                $id = $entity[$this->routeIdentifier];
            }
        } catch (MapperException $exception) {
            return $response->withStatus(400);
        }
        $response = $response->withHeader(
            'Location',
            $this->helper->generate(
                $this->routeName . '.get',
                [$this->routeIdentifier => $id]
            )
        );
        return $response->withStatus(201);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface|JsonResponse
     */
    public function patch(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute($this->routeIdentifier);
        try {
            $entity = $this->mapper->update($id, $request->getParsedBody());
        } catch (MapperException $exception) {
            return $response->withStatus(400);
        }
        if (!$entity) {
            return $response->withStatus(404);
        }
        return new JsonResponse([$this->resourceName => $entity]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface|EmptyResponse
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute($this->routeIdentifier);
        $result = $this->mapper->delete($id);
        if (!$result) {
            return $response->withStatus(404);
        }
        return new EmptyResponse();
    }
}
