<?php

namespace spec\terehinis\JWTRefreshTokenBundle\Service;

use terehinis\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use terehinis\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use terehinis\JWTRefreshTokenBundle\Security\Authenticator\RefreshTokenAuthenticator;
use terehinis\JWTRefreshTokenBundle\Security\Provider\RefreshTokenProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class RefreshTokenSpec extends ObjectBehavior
{
    public function let(RefreshTokenAuthenticator $authenticator, RefreshTokenProvider $provider, AuthenticationSuccessHandler $successHandler, AuthenticationFailureHandler $failureHandler, RefreshTokenManagerInterface $refreshTokenManager, TokenInterface $token, UserProviderInterface $userProvider, $ttl, $providerKey, $ttlUpdate, EventDispatcherInterface $eventDispatcher)
    {
        $ttl = 2592000;
        $ttlUpdate = false;
        $providerKey = 'testkey';

        $this->beConstructedWith($authenticator, $provider, $successHandler, $failureHandler, $refreshTokenManager, $ttl, $providerKey, $ttlUpdate, $eventDispatcher);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('terehinis\JWTRefreshTokenBundle\Service\RefreshToken');
    }

    public function it_refresh_token(Request $request, $refreshTokenManager, $authenticator, $token, PreAuthenticatedToken $preAuthenticatedToken, RefreshTokenInterface $refreshToken)
    {
        $authenticator->createToken(Argument::any(), Argument::any())->willReturn($token);
        $authenticator->authenticateToken(Argument::any(), Argument::any(), Argument::any())->willReturn($preAuthenticatedToken);

        $refreshTokenManager->get(Argument::any())->willReturn($refreshToken);
        $refreshToken->isValid()->willReturn(true);

        $this->refresh($request);
    }

    public function it_refresh_token_with_ttl_update(RefreshTokenProvider $provider, AuthenticationSuccessHandler $successHandler, AuthenticationFailureHandler $failureHandler, Request $request, $refreshTokenManager, $authenticator, $token, PreAuthenticatedToken $preAuthenticatedToken, RefreshTokenInterface $refreshToken, EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($authenticator, $provider, $successHandler, $failureHandler, $refreshTokenManager, 2592000, 'testkey', true, $eventDispatcher);

        $authenticator->createToken(Argument::any(), Argument::any())->willReturn($token);
        $authenticator->authenticateToken(Argument::any(), Argument::any(), Argument::any())->willReturn($preAuthenticatedToken);

        $refreshTokenManager->get(Argument::any())->willReturn($refreshToken);
        $refreshToken->isValid()->willReturn(true);

        $refreshToken->setValid(Argument::any())->shouldBeCalled();
        $refreshTokenManager->save($refreshToken)->shouldBeCalled();

        $this->refresh($request);
    }

    public function it_throws_an_authentication_exception(Request $request, $refreshTokenManager, $authenticator, $token, PreAuthenticatedToken $preAuthenticatedToken, RefreshTokenInterface $refreshToken, $failureHandler)
    {
        $authenticator->createToken(Argument::any(), Argument::any())->willReturn($token);
        $authenticator->authenticateToken(Argument::any(), Argument::any(), Argument::any())->willReturn($preAuthenticatedToken);

        $failureHandler->onAuthenticationFailure(Argument::any(), Argument::any())->shouldBeCalled();

        $this->refresh($request);
    }
}
