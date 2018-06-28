<?php

/*
 * This file is part of the terehinisJWTRefreshTokenBundle package.
 *
 * (c) terehinis <http://www.terehinis.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace terehinis\JWTRefreshTokenBundle\Event;

use terehinis\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;

class RefreshEvent extends Event
{
    private $refreshToken;

    private $preAuthenticatedToken;

    public function __construct(RefreshTokenInterface $refreshToken, PreAuthenticatedToken $preAuthenticatedToken)
    {
        $this->refreshToken = $refreshToken;
        $this->preAuthenticatedToken = $preAuthenticatedToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function getPreAuthenticatedToken()
    {
        return $this->preAuthenticatedToken;
    }
}
