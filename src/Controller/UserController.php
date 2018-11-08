<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/welcome/{id}", name="userwelcome")
     */
    public function userWelcome($id,
        Request $request,
        EntityManagerInterface $em)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->find($id);

        return $this->render('default/index.html.twig', [
            "user" => $user
        ]);
    }

    /**
     * @Route("/", name="register")
     */
    public function register(Request $request,
                            EntityManagerInterface $em,
                            \Swift_Mailer $mailer)
    {
        $user = new User();
        $registerForm = $this->createForm(UserType::class, $user);
        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {

            $message = (new \Swift_Message('New user'))
                ->setFrom('frederic.bourelle@gmail.com')
                ->setTo('bfredericb@hotmail.com')
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'emails/registration.html.twig',
                        array('name' => $user->getName(),
                               'firstname' => $user->getFirstname(),
                               'email' => $user->getEmail())
                    ),
                    'text/html'
                );
            
            $mailer->send($message);

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $user->getPicture();
            if (!empty($file)) {
                $fileName = $this->generateUniqueFilename().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('pictures_directory'),
                        $fileName
                    );
                } catch (FileException $e) {

                }
                $user->setPicture($fileName);
            
            } else {
                $user->setPicture('default_picture.png');
            }
            
            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "You're registered");
            return $this->redirectToRoute('userwelcome', ["id" => $user->getId()]);
        }

        return $this->render('user/register.html.twig', [
            'registerForm' => $registerForm->createView()
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

}
