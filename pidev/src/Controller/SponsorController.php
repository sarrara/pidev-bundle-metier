<?php

namespace App\Controller;

use App\Entity\Sponsor;
use App\Form\SponsorType;
use App\Repository\SponsorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sponsor")
 */
class SponsorController extends AbstractController
{
    /**
     * @Route("/", name="sponsor_index", methods={"GET"})
     */
    public function index(SponsorRepository $sponsorRepository): Response
    {
        return $this->render('sponsor/index.html.twig', [
            'sponsors' => $sponsorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/front", name="sponsor_front", methods={"GET"})
     */
    public function indexFront(SponsorRepository $sponsorRepository): Response
    {
        return $this->render('sponsor/FrontSponsor.html.twig', [
            'sponsors' => $sponsorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sponsor_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sponsor = new Sponsor();
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sponsor->getUploadFile();
            $sponsor->getUploadFileImage();
            $entityManager->persist($sponsor);
            $entityManager->flush();

            return $this->redirectToRoute('sponsor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sponsor/new.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sponsor_show", methods={"GET"})
     */
    public function show(Sponsor $sponsor): Response
    {
        return $this->render('sponsor/show.html.twig', [
            'sponsor' => $sponsor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sponsor_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sponsor $sponsor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($sponsor->getFile() != null){
                $sponsor->getUploadFile();
            }
            if ($sponsor->getFileimage() != null){
                $sponsor->getUploadFileImage();
            }
            $entityManager->flush();

            return $this->redirectToRoute('sponsor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sponsor/edit.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="sponsor_delete")
     */
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sponsor= $em->getRepository(Sponsor::class)->find($id);
        $em->remove($sponsor);
        $em->flush();
        return $this->redirectToRoute('sponsor_index');
    }
}
