<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use  Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ApiTokenAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    public function __construct(private TranslatorInterface $translator, private Environment $twig, private UserRepository $userRepository)
    {
    }

    public function supports(Request $request): ?bool
    {
        if (!$request->headers->has('Authorization')) {
            return false;
        }
        $authorizationHeader = $request->headers->get('Authorization');
        
        if (null === $authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer')) {
            return false;
        }

        return true;
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        /** @var string $authorizationHeader */
        $authorizationHeader = $request->headers->get('Authorization');
        $receivedToken = substr($authorizationHeader, 7);
        /** @var ?User $user */
        $user = $this->userRepository->findOneBy([
            'token' => $receivedToken,
        ]);
        if (null === $user) {
            throw new CustomUserMessageAuthenticationException('Invalid Token');
        }

        /** @var string $userIdentifier */
        $userIdentifier = $user->getUserIdentifier();
        $userBadge = new UserBadge($userIdentifier);

        return new SelfValidatingPassport($userBadge);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?JsonResponse
    {
        $message = $this->translator->trans($exception->getMessageKey(), $exception->getMessageData(), 'security');

        return new JsonResponse(['message' => $message], 401);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function start(Request $request, AuthenticationException $authException = null): ?Response
    {
        $message = $authException ? $this->translator->trans($authException->getMessageKey(), $authException->getMessageData(), 'security') : '';

        return new Response($this->twig->render('error/api_authenticator.html.twig', [
            'message' => $message,
        ]), 401);
    }
}
