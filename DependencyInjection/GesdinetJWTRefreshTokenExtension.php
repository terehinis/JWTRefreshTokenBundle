<?php

/*
 * This file is part of the terehinisJWTRefreshTokenBundle package.
 *
 * (c) terehinis <http://www.terehinis.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace terehinis\JWTRefreshTokenBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class terehinisJWTRefreshTokenExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('terehinis_jwt_refresh_token.ttl', $config['ttl']);
        $container->setParameter('terehinis_jwt_refresh_token.ttl_update', $config['ttl_update']);
        $container->setParameter('terehinis_jwt_refresh_token.security.firewall', $config['firewall']);
        $container->setParameter('terehinis_jwt_refresh_token.user_provider', $config['user_provider']);
        $container->setParameter('terehinis_jwt_refresh_token.user_identity_field', $config['user_identity_field']);

        //if refresh_token_entity has not be defined in config, we don't want to erase base value
        if (isset($config['refresh_token_entity'])) {
            $container->setParameter('terehinis.jwtrefreshtoken.refresh_token.class', $config['refresh_token_entity']);
        }

        $container->setParameter('terehinis.jwtrefreshtoken.entity_manager.id', $config['entity_manager']);
    }
}
