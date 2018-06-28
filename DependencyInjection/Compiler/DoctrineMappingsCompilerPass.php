<?php

namespace terehinis\JWTRefreshTokenBundle\DependencyInjection\Compiler;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class DoctrineMappingsCompilerPass.
 *
 * We can't add DoctrineOrmMappingsPass directly, because in terehinisJWTRefreshTokenBundle->build we don't have current
 * bundle configuration yet.
 * This CompilerPass is effectively just a wrapper for DoctrineOrmMappingsPass, which passes mappings conditionally.
 */
final class DoctrineMappingsCompilerPass implements CompilerPassInterface
{
    /**
     * Process Doctrine mappings based on terehinis_jwt_refresh_token.refresh_token_entity config parameter.
     * If this parameter contains user-defined entity, RefreshToken will be registered as a mapped superclass, not as an
     * entity, to prevent Doctrine creating table for it and avoid conflicts with user-defined entity.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__.'/../../Resources/config/doctrine-orm') => 'terehinis\JWTRefreshTokenBundle\Entity',
        );
        $config = $container->getExtensionConfig('terehinis_jwt_refresh_token')[0];
        if (isset($config['refresh_token_entity'])) {
            $mappings[realpath(__DIR__.'/../../Resources/config/doctrine-superclass')] = 'terehinis\JWTRefreshTokenBundle\Entity';
        } else {
            $mappings[realpath(__DIR__.'/../../Resources/config/doctrine-entity')] = 'terehinis\JWTRefreshTokenBundle\Entity';
        }

        $pass = DoctrineOrmMappingsPass::createYamlMappingDriver($mappings);
        $pass->process($container);
    }
}
