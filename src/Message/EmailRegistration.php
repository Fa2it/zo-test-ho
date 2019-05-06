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
        /*@var ActCode $actcode */
        $act_code = $user->getActCode();

        $message = (new \Swift_Message('Zooya Aktivierung'))
            ->setFrom('info@zooya.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                // templates/emails/registration.html.twig
                    'registration/email.message.html.twig',
                    [
                        'name' => $user->getFirstName(),
                        'emailCode' => $act_code->getEmailCode(),
                    ]
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
        // dump(['sending mail']); die;
        $this->mailer->send($message);
    }

    public function sendPassword(User $user, $password, $pwdCode_in ){

        $message = (new \Swift_Message('Zooya Neu Password'))
            ->setFrom('info@zooya.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                // templates/emails/registration.html.twig
                    'registration/password.message.html.twig',
                    [
                        'user' => $user,
                        'NeuPassword' => $password,
                        'pwdCode'=>$pwdCode_in,
                    ]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

}