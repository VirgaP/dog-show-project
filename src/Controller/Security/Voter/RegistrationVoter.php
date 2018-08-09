<?php

namespace App\Controller\Security\Voter;

use App\Entity\Dog;
use App\Entity\Owner;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Registration;
use FOS\UserBundle\Model\User as BaseUser;


class RegistrationVoter extends Voter
{
    const EDIT = 'edit';
    const SEE = 'see';
    const DELETE = 'delete';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::EDIT, self::SEE, self::DELETE))) {
            return false;
        }

        if (!$subject instanceof Registration) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {

        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_ADMIN can do anything!
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }


        /** @var Registration $registration */
        $registration = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($registration, $user);
            case self::SEE:
                return $this->canSee($registration, $user);
            case self::DELETE:
                return $this->canDelete($registration, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Registration $registration, User $user)
    {
        return $user === $registration->getDog()->getOwner()->getUser();
    }

    private function canSee(Registration $registration,  User $user)
    {
        return $user === $registration->getDog()->getOwner()->getUser();
    }

    private function canDelete(Registration $registration,  User $user)
    {
        if ($this->canEdit($registration, $user)) {
            return true;
        }
    }

}
