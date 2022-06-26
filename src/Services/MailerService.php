<?php
namespace App\Services ;

// use Twig\Environment;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService{
    
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
        // $this->twig->$twig;    
    }

    public function send($data,string $subject="Creation de Compte"):void
    {
        $from="syelaj314@gmail.com";
        $email = (new Email())
            ->from($from)
            ->to($data->getLogin())
            ->subject($subject)
            ->html("Bienvenue");
        $this->mailer->send($email);

    }
}