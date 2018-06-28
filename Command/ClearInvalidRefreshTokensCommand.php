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
class ClearInvalidRefreshTokensCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('terehinis:jwt:clear')
            ->setDescription('Clear invalid refresh tokens.')
            ->setDefinition(array(
                new InputArgument('datetime', InputArgument::OPTIONAL),
            ));
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $datetime = $input->getArgument('datetime');

        if (null === $datetime) {
            $datetime = new \DateTime();
        } else {
            $datetime = new \DateTime($datetime);
        }

        $manager = $this->getContainer()->get('terehinis.jwtrefreshtoken.refresh_token_manager');
        $revokedTokens = $manager->revokeAllInvalid($datetime);

        foreach ($revokedTokens as $revokedToken) {
            $output->writeln(sprintf('Revoke <comment>%s</comment>', $revokedToken->getRefreshToken()));
        }
    }
}
