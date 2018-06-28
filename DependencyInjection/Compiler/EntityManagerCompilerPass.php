<?php

namespace terehinis\JWTRefreshTokenBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * CustomUserProviderCompilerPass.
 */
final class EntityManagerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $entityManagerId = $container->getParameter('terehinis.jwtrefreshtoken.entity_manager.id');
        if (!$entityManagerId) {
            return;
        }

        $container->setAlias('terehinis.jwtrefreshtoken.entity_manager', $entityManagerId);
    }
}
