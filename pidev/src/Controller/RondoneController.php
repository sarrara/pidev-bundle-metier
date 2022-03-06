<?php

namespace App\Controller;

use App\Entity\randonnee;
use App\Form\RandonneeType;
use App\Repository\RandonneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rondonne")
 */
class RondoneController extends AbstractController
{

        /**
     * @Route("/delete/{id}", name="camping_delete")
     */
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $camping = $em->getRepository(randonnee::class)->find($id);
        $em->remove($camping);
        $em->flush();
        return $this->redirectToRoute('camping_index');

    }

    /**
     * @Route("/detailsRon/{id}", name="camping_details", methods={"GET"})
     */
    public function indexdetails(RandonneeRepository $campingRepository,$id): Response
    {
        return $this->render('camping/detailsRondo.html.twig', [
            'camping' => $campingRepository->find($id),
        ]);
    }

    /**
     * @Route("/front", name="camping_front", methods={"GET"})
     */
    public function indexFront(RandonneeRepository $campingRepository): Response
    {
        return $this->render('camping/CampinFront.html.twig', [
            'campings' => $campingRepository->findAll(),
        ]);
    }


    /**
     * @Route("/", name="camping_index", methods={"GET"})
     */
    public function index(RandonneeRepository $campingRepository): Response
    {
        return $this->render('camping/index.html.twig', [
            'campings' => $campingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="camping_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $camping = new randonnee();
        $form = $this->createForm(RandonneeType::class, $camping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($camping);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Randonnée ajoutée !'
            );

            return $this->redirectToRoute('camping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('camping/new.html.twig', [
            'camping' => $camping,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="camping_show", methods={"GET"})
     */
    public function show(randonnee $camping): Response
    {
        return $this->render('camping/show.html.twig', [
            'camping' => $camping,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="camping_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, randonnee $camping, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RandonneeType::class, $camping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($camping->getFile() != null){
                $camping->getUploadFile();
            }
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Randonnée Modifiée !'
            );
            $entityManager->flush();

            return $this->redirectToRoute('camping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('camping/edit.html.twig', [
            'camping' => $camping,
            'form' => $form->createView(),
        ]);
    }


}
