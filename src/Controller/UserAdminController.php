<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Matter;
use App\Form\NoteType;
use App\Form\MatterType;
use App\Repository\NoteRepository;
use App\Repository\UserRepository;
use App\Repository\MatterRepository;
use App\Repository\StudentUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class UserAdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function index(MatterRepository $matterRepository, UserRepository $userRepository, StudentUserRepository $studentUserRepository): Response
    {
        return $this->render('admin/matter/index.html.twig', [
            'matters' => $matterRepository->findAll(),
            'studentUsers' => $studentUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/prof", name="adminProf_index", methods={"GET"})
     */
    public function indexProf(MatterRepository $matterRepository, UserRepository $userRepository, StudentUserRepository $studentUserRepository): Response
    {
        return $this->render('admin/prof/index.html.twig', [
            'matters' => $matterRepository->findAll(),
            'studentUsers' => $studentUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/student", name="adminStudent_index", methods={"GET"})
     */
    public function indexStudent(MatterRepository $matterRepository, UserRepository $userRepository, StudentUserRepository $studentUserRepository, NoteRepository $noteRepository): Response
    {
        return $this->render('admin/student/index.html.twig', [
            'matters' => $matterRepository->findAll(),
            'studentUsers' => $studentUserRepository->findAll(),
            'notes' => $noteRepository->findAll(),
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $matter = new Matter();
        $form = $this->createForm(MatterType::class, $matter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matter);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/matter/new.html.twig', [
            'matter' => $matter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(Matter $matter): Response
    {
        return $this->render('admin/matter/show.html.twig', [
            'matter' => $matter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Matter $matter): Response
    {
        $form = $this->createForm(MatterType::class, $matter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/matter/edit.html.twig', [
            'matter' => $matter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Matter $matter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($matter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route("/noteExemple", name="issous", methods={"GET"})
     */
    public function indexNote(NoteRepository $noteRepository): Response
    {
        return $this->render('admin/note/index.html.twig', [
            'notes' => $noteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/noteExemple/new", name="issou", methods={"GET","POST"})
     */
    public function newNote(Request $request): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('noteProfIndex');
        }

        return $this->render('admin/note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }
}
