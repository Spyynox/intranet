<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("student/note")
 */
class NoteStudentController extends AbstractController
{
    /**
     * @Route("/", name="note_index", methods={"GET"})
     */
    public function index(NoteRepository $noteRepository): Response
    {
        // $this->denyAccessUnlessGranted(['ROLE_PROF', 'ROLE_ADMIN'], null, 'You cannot edit this item.'); 
        return $this->render('noteStudent/index.html.twig', [
            'notes' => $noteRepository->findAll(),
        ]);
    }
}
