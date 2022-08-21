<?php
namespace App\Services;

use App\Entity\Menu;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CallbackMenuService{

    public static function validate($object, ExecutionContextInterface $context, $payload)
    {
        if (empty ($object->getMenuTailles()[0]) && empty ($object->getMenuFrites()[0])) 
        {            
            $context->buildViolation('Ajouter au moins un Complement dans le Menu')
                ->atPath('menu')
                ->addViolation();
        }
    }
}