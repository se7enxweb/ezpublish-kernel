<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Bundle\EzPublishCoreBundle\ApiLoader;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class CacheFactory.
 *
 * Service "ezpublish.cache_pool", selects a Symfony cache service based on siteaccess[-group] setting "cache_service_name"
 */
class CacheFactory implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ConfigResolverInterface $configResolver
     *
     * @return \Symfony\Component\Cache\Adapter\TagAwareAdapterInterface
     */
    public function getCachePool(ConfigResolverInterface $configResolver = null)
    {
        $cacheService = null;

        if ($configResolver !== null) {
            $cacheServiceName = $configResolver->getParameter('cache_service_name');
	    /** @var \Symfony\Component\Cache\Adapter\AdapterInterface $cacheService */
            $cacheService = $this->container->get($cacheServiceName);
        } else {
            $cacheService = $this->container->get('cache.app');
        }

        // If cache service is already implementing TagAwareAdapterInterface, return as-is
        if ($cacheService instanceof TagAwareAdapterInterface) {
            return $cacheService;
        }

        return new TagAwareAdapter(
	     $cacheService
	 );
    }
}
