<?php

namespace terehinis\JWTRefreshTokenBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * CustomUserProviderCompilerPass.
 */
final class CustomUserProviderCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $customUserProvider = $container->getParameter('terehinis_jwt_refresh_token.user_provider');
        if (!$customUserProvider) {
            return;
        }
        if (!$container->hasDefinition('terehinis.jwtrefreshtoken.user_provider')) {
            return;
        }

        $definition = $container->getDefinition('terehinis.jwtrefreshtoken.user_provider');

        $definition->addMethodCall(
            'setCustomUserProvider',
            array(new Reference($customUserProvider, ContainerInterface::NULL_ON_INVALID_REFERENCE, false))
        );
    }
}
