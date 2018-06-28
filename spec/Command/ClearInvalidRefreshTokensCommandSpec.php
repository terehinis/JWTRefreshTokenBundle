<?php

namespace spec\terehinis\JWTRefreshTokenBundle\Command;

use terehinis\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use terehinis\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ClearInvalidRefreshTokensCommandSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('terehinis\JWTRefreshTokenBundle\Command\ClearInvalidRefreshTokensCommand');
    }

    public function it_is_a_command()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand');
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldReturn('terehinis:jwt:clear');
    }

    public function it_clears_invalid_refresh_tokens(ContainerInterface $container, InputInterface $input, OutputInterface $output, RefreshTokenManagerInterface $refreshTokenManager, RefreshTokenInterface $revokedToken)
    {
        $container->get('terehinis.jwtrefreshtoken.refresh_token_manager')->shouldBeCalled()->willReturn($refreshTokenManager);
        $refreshTokenManager->revokeAllInvalid(Argument::any())->shouldBeCalled()->willReturn(array($revokedToken));

        $output->writeln(Argument::any())->shouldBeCalled();

        $this->setContainer($container);
        $this->run($input, $output);
    }
}
