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
    public function index(MatterRepository $matterRepository, StudentUserRepository $studentUserRepository, UserRepository $userRepository): Response
    {
        return $this->render('profMatter/index.html.twig', [
            'matters' => $matterRepository->findAll(),
            'studentUsers' => $studentUserRepository->findAll(),
            'users' => $userRepository->findAll(),
        ]);
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
