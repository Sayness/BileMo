<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerVoter extends Voter
{
    public const manage = 'manage';
    public const VIEW = 'POST_VIEW';
    public const delete ='delete';
    public const edit ='edit';


    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::manage,self::edit,self::delete, self::VIEW])
            && $subject instanceof \App\Entity\Customer;
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
            case self::manage:
                if ($subject->getCustomer() == $user) {
                    return true;
                }
                break;
               
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                break;
            case self::edit:
                if ($subject->getCustomer() == $user) {
                    return true;
                }
                break;  
            case self::delete:
                if ($subject->getCustomer() == $user) {
                    return true;
                }
                break;      
        }

        return false;
    }
}
