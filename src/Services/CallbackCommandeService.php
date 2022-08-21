<?php
namespace App\Services;

use App\Entity\Commande;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CallbackCommandeService{

    public static function validate($object, ExecutionContextInterface $context, $payload)
    {
        if (empty ($object->getCommandeBoissonTailles()[0]) && empty ($object->getCommandeFrites()[0])) 
        {            
            $context->buildViolation('Ajouter au moins un Complement dans la Commande')
                ->atPath('commande')
                ->addViolation();
        }
    }
}