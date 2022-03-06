<?php

namespace App\Controller;

use App\Entity\Activitie;
use App\Form\ActivitieType;
use App\Repository\ActivitieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activitie")
 */
class ActivitieController extends AbstractController
{
    /**
     * @Route("/", name="activitie_index", methods={"GET"})
     */
    public function index(ActivitieRepository $activitieRepository): Response
    {
        return $this->render('activitie/index.html.twig', [
            'activities' => $activitieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="activitie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activitie = new Activitie();
        $form = $this->createForm(ActivitieType::class, $activitie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($activitie);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Activité ajoutée !'
            );
            return $this->redirectToRoute('activitie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activitie/new.html.twig', [
            'activitie' => $activitie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activitie_show", methods={"GET"})
     */
    public function show(Activitie $activitie): Response
    {
        return $this->render('activitie/show.html.twig', [
            'activitie' => $activitie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activitie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Activitie $activitie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivitieType::class, $activitie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();
   
            return $this->redirectToRoute('activitie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activitie/edit.html.twig', [
            'activitie' => $activitie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("delete/{id}", name="activitie_delete")
     */
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $activite = $em->getRepository(Activitie::class)->find($id);
        $em->remove($activite);
      
        $em->flush();
        return $this->redirectToRoute('activitie_index');
    }
}
