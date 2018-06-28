<?php

namespace terehinis\JWTRefreshTokenBundle;

use terehinis\JWTRefreshTokenBundle\DependencyInjection\Compiler\CustomUserProviderCompilerPass;
use terehinis\JWTRefreshTokenBundle\DependencyInjection\Compiler\DoctrineMappingsCompilerPass;
use terehinis\JWTRefreshTokenBundle\DependencyInjection\Compiler\EntityManagerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class terehinisJWTRefreshTokenBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CustomUserProviderCompilerPass());
        $container->addCompilerPass(new EntityManagerCompilerPass());

        if (class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
            $container->addCompilerPass(new DoctrineMappingsCompilerPass());
        }
    }
}
