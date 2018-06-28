<?php

/*
 * This file is part of the terehinisJWTRefreshTokenBundle package.
 *
 * (c) terehinis <http://www.terehinis.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace terehinis\JWTRefreshTokenBundle\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Refresh Token.
 *
 * @UniqueEntity("refreshToken")
 */
class RefreshToken extends AbstractRefreshToken
{
    /**
     * @var int
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        $this->id;
    }
}
