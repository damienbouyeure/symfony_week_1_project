<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Form\LoginUserType;
use App\Form\ProfileUserType;
use App\Form\RegisterUserType;
use App\Form\VideoType;
use App\Manager\VideoManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /** * @Route("/register", name="register") */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('security/register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $user = new User();
        $form = $this->createForm(LoginUserType::class, $user);
        return $this->render('security/login.html.twig', ['error' => $authenticationUtils->getLastAuthenticationError(), 'form' => $form->createView()]);
    }

    /** * @Route("/profile", name="profile") */
    public function profile(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('security/profile.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
    /** * @Route("/user/video", name="user_video") */
    public function userVideo(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        return $this->render('security/video.html.twig', [ 'user' => $user]);
    }
    /** * @Route("/user/video/create", name="user_createvideo") */
    public function userCreateVideo(Request $request, EntityManagerInterface $entityManager)
    {
        $video = new Video();
        $user = $this->getUser();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $video->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();
            return $this->redirectToRoute('user_video');
        }
        return $this->render('security/createVideo.html.twig', ['form' => $form->createView(),'user' => $user]);
    }
    /** * @Route("/user/video/edit/{id}", name="user_editvideo") */
    public function userEditVideo(Request $request, EntityManagerInterface $entityManager, int $id, VideoManager $videoManager)
    {
        $video = $videoManager->findById($id);
        $user = $this->getUser();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();
            return $this->redirectToRoute('user_video');
        }
        return $this->render('security/editVideo.html.twig', ['form' => $form->createView(),'user' => $user]);
    }
    /** * @Route("/user/video/remove/{id}", name="video_remove")  */
    public function remove(int $id, VideoManager $videoManager, EntityManagerInterface $entityManager)
    {
        $video = $videoManager->findById($id);
        $entityManager->remove($video);
        $entityManager->flush();
        return $this->redirectToRoute('user_video');
    }

}
