<?php

namespace App\Controller;

use App\Entity\StudentUser;
use App\Form\StudentUserType;
use App\Repository\StudentUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/student/user")
 * @IsGranted("ROLE_STUDENT", statusCode=404, message="issou")
 */
class StudentUserController extends AbstractController
{
    /**
     * @Route("/", name="student_user_index", methods={"GET"})
     */
    public function index(StudentUserRepository $studentUserRepository): Response
    {
        return $this->render('student_user/index.html.twig', [
            'student_users' => $studentUserRepository->findAll(),
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

            return $this->redirectToRoute('student_user_index');
        }

        return $this->render('student_user/new.html.twig', [
            'student_user' => $studentUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_user_show", methods={"GET"})
     */
    public function show(StudentUser $studentUser): Response
    {
        return $this->render('student_user/show.html.twig', [
            'student_user' => $studentUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StudentUser $studentUser): Response
    {
        $form = $this->createForm(StudentUserType::class, $studentUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_user_index');
        }

        return $this->render('student_user/edit.html.twig', [
            'student_user' => $studentUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StudentUser $studentUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($studentUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('student_user_index');
    }
}
