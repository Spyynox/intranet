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
 * @Route("/prof")
 */
class ProfsController extends AbstractController
{
    /**
     * @Route("/", name="app_profs_index", methods={"GET"})
     */
    public function index(MatterRepository $matterRepository, StudentUserRepository $studentUserRepository): Response
    {
        return $this->render('profMatter/index.html.twig', [
            'matters' => $matterRepository->findAll(),
            'studentUsers' => $studentUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="matter_new", methods={"GET","POST"})
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

            return $this->redirectToRoute('app_profs_index');
        }

        return $this->render('profMatter/new.html.twig', [
            'matter' => $matter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="matter_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(Matter $matter): Response
    {
        return $this->render('profMatter/show.html.twig', [
            'matter' => $matter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="matter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Matter $matter): Response
    {
        $form = $this->createForm(MatterType::class, $matter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('matter_index');
        }

        return $this->render('profMatter/edit.html.twig', [
            'matter' => $matter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="matter_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Matter $matter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($matter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('matter_index');
    }

    /**
     * @Route("/note", name="noteProfIndex", methods={"GET"})
     */
    public function indexNote(NoteRepository $noteRepository): Response
    {
        return $this->render('profMatter/note/index.html.twig', [
            'notes' => $noteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/note/new", name="noteProf_new", methods={"GET","POST"})
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

        return $this->render('profMatter/note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }
}
