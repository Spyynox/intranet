<?php

namespace App\Controller;

use App\Entity\Matter;
use App\Form\StudentType;
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
     * @Route("/{id}/edit", name="student_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Matter $matter): Response
    {
        $form = $this->createForm(StudentType::class, $matter);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {    
            // $matter->setStudent($this->getUser());
            // $this->getDoctrine()->getManager()->persist($matter);
            // $this->getDoctrine()->getManager()->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('student_index');
        }

        return $this->render('student/edit.html.twig', [
            'matter' => $matter,
            'form' => $form->createView(),
        ]);
    }
}