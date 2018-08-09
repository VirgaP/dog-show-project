<?php
/**
 * Created by PhpStorm.
 * User: virga
 * Date: 2018-07-29
 * Time: 19:45
 */

namespace App\Controller\Security\Voter;


use App\Entity\Dog;
use FOS\UserBundle\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DogVoter extends Voter
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

        if (!$subject instanceof Dog) {
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


        /** @var Dog $dog */

        $dog = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($dog, $user);
            case self::SEE:
                return $this->canSee($dog, $user);
            case self::DELETE:
                return $this->canDelete($dog, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Dog $dog, User $user)
    {

        return $user === $dog->getOwner()->getUser();
    }

    private function canSee(Dog $dog,  User $user)
    {
        return $user === $dog->getOwner()->getUser();
        dump($dog->getOwner()->getUser());
    }

    private function canDelete(Dog $dog,  User $user)
    {
        if ($this->canEdit($dog, $user)) {
            return true;
        }
    }
}