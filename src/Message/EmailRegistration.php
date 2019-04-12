<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 12.04.2019
 * Time: 03:15
 */

namespace App\Message;


use App\Entity\User;

class EmailRegistration
{
    private $mailer;
    private $templating;


    public function __construct(\Swift_Mailer  $mailer,  \Twig\Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function send(User $user){

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                // templates/emails/registration.html.twig
                    'registration/email.message.html.twig',
                    ['name' => $user->getFirstName()]
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'emails/registration.txt.twig',
                    ['name' => $name]
                ),
                'text/plain'
            )
            */
        ;

        $this->mailer->send($message);
    }

}