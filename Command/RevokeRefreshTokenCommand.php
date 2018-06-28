<?php

/*
 * This file is part of the terehinisJWTRefreshTokenBundle package.
 *
 * (c) terehinis <http://www.terehinis.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace terehinis\JWTRefreshTokenBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClearInvalidRefreshTokensCommand.
 */
class RevokeRefreshTokenCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('terehinis:jwt:revoke')
            ->setDescription('Revoke a refresh token')
            ->setDefinition(array(
                new InputArgument('refresh_token', InputArgument::REQUIRED, 'The refresh token to revoke'),
            ));
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $refreshTokenParam = $input->getArgument('refresh_token');

        $manager = $this->getContainer()->get('terehinis.jwtrefreshtoken.refresh_token_manager');
        $refreshToken = $manager->get($refreshTokenParam);

        if (null === $refreshToken) {
            $output->writeln(sprintf('<error>Not Found:</error> Refresh Token <comment>%s</comment> doesn\'t exists', $refreshTokenParam));

            return -1;
        }

        $manager->delete($refreshToken);

        $output->writeln(sprintf('Revoke <comment>%s</comment>', $refreshToken->getRefreshToken()));
    }
}
