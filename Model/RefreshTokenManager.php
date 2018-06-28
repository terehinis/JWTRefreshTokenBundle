<?php

/*
 * This file is part of the terehinisJWTRefreshTokenBundle package.
 *
 * (c) terehinis <http://www.terehinis.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace terehinis\JWTRefreshTokenBundle\Model;

abstract class RefreshTokenManager implements RefreshTokenManagerInterface
{
    /**
     * Creates an empty RefreshToken instance.
     *
     * @return RefreshTokenInterface
     */
    public function create()
    {
        $class = $this->getClass();

        return new $class();
    }
}
