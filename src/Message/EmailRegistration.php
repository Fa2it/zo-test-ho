<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 12.04.2019
 * Time: 03:15
 */

namespace App\Message;


use App\Entity\User;
use App\Helper\CodeGenerator\CodeGenerator;

class EmailRegistration
{
    private $mailer;
    private $templating;
    private $cg;


    public function __construct(\Swift_Mailer  $mailer,  \Twig\Environment $templating, CodeGenerator $cg)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->cg = $cg;
    }

    public function send(User $user ){
        /*@var ActCode $actcode */
        $act_code = $user->getActCode();

        $message = (new \Swift_Message('Zooya Aktivierung'))
            ->setFrom('info@zooya.de')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                // templates/emails/registration.html.twig
                    'registration/email.message.html.twig',
                    [
                        'name' => $user->getFirstName(),
                        'emailCode' => $act_code->getEmailCode(),
                        'sbCode' => $this->cg->emailEncode( $user->getEmail() ),
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
            ->setFrom('info@zooya.de')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                // templates/emails/registration.html.twig
                    'registration/password.message.html.twig',
                    [
                        'user' => $user,
                        'NeuPassword' => $password,
                        'pwdCode'=>$pwdCode_in,
                        'sbCode' => $this->cg->emailEncode( $user->getEmail() ),
                    ]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

}