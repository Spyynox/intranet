<?php

namespace App\Controller;

use App\Entity\Matter;
use App\Form\MatterType;
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
class ProfController extends AbstractController
{
    /**
     * @Route("/", name="matter_index", methods={"GET"})
     */
    public function index(MatterRepository $matterRepository, UserRepository $userRepository, StudentUserRepository $studentUserRepository): Response
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

            return $this->redirectToRoute('matter_index');
        }

        return $this->render('profMatter/new.html.twig', [
            'matter' => $matter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="matter_show", methods={"GET"})
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
}
