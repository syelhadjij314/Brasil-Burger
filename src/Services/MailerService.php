<?php
namespace App\Services ;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailerService{
    
    public function __construct(MailerInterface $mailer,Environment $twig)
    {
        $this->mailer=$mailer;
        $this->twig=$twig;   
    }

    public function send($data,string $object="Creation de Compte"):void
    {
        $email = (new Email())
            ->from("syelaj314@gmail.com")
            ->to($data->getLogin())
            ->subject($object)
            ->html($this->twig->render("email/index.html.twig", [
                "data"=>$data,
                "token"=>$data->getToken(),
            ])); 
        $this->mailer->send($email);

    }
}