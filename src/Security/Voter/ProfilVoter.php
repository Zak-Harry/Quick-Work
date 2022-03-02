<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfilVoter extends Voter
{
    public const EDIT = 'PROFIL_EDIT';
    public const VIEW = 'PROFIL_VIEW';
    public const CREATE = 'PROFIL_CREATE';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        if($attribute === self::EDIT || $attribute === self::VIEW || $attribute === self::CREATE)
        {
            return true;
        }
        return false;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
            case self::CREATE:
                if($this->security->isGranted('ROLE_RH')){ return true;};
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                return true;
                break;
        }

        return false;
    }
}
