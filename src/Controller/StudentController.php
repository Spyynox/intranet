<?php

namespace App\Controller;

use App\Entity\Matter;
use App\Form\StudentType;
use App\Entity\StudentUser;
use App\Form\StudentUserType;
use App\Repository\UserRepository;
use App\Repository\MatterRepository;
use App\Repository\StudentUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/student")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="student_index", methods={"GET"})
     */
    public function index(MatterRepository $matterRepository, UserRepository $userRepository, StudentUserRepository $studentUserRepository): Response
    {
        return $this->render('student/index.html.twig', [
            'matters' => $matterRepository->findAll(),
            'users' => $userRepository->findAll(),
            'studentUsers' => $studentUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="student_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $studentUser = new StudentUser();
        $form = $this->createForm(StudentUserType::class, $studentUser);
        $form->handleRequest($request);
        $user = $this->getUser();
        $studentUser->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($studentUser);
            $entityManager->flush();

            return $this->redirectToRoute('student_index');
        }

        return $this->render('student/new.html.twig', [
            'student_user' => $studentUser,
            'form' => $form->createView(),
        ]);
    }
}