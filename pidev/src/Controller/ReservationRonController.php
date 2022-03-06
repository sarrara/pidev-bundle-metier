<?php

namespace App\Controller;

use App\Entity\ReservationRon;
use App\Form\ReservationRonType;
use App\Repository\RandonneeRepository;
use App\Repository\ReservationRonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation/ron")
 */
class ReservationRonController extends AbstractController
{

    /**
     * @Route("/mesparticipation", name="reservation_ron_participation", methods={"GET"})
     */
    public function mesParticipation(ReservationRonRepository $reservationRonRepository): Response
    {
        return $this->render('reservation_ron/mesRondonne.html.twig', [
            'reservation_rons' => $reservationRonRepository->findBy(array('idUser'=>$this->getUser())),
        ]);
    }

    /**
     * @Route("/index", name="reservation_ron_index", methods={"GET"})
     */
    public function index(ReservationRonRepository $reservationRonRepository): Response
    {
        return $this->render('reservation_ron/index.html.twig', [
            'reservation_rons' => $reservationRonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="reservation_ron_new", methods={"GET", "POST"})
     */
    public function new(Request $request,RandonneeRepository $randonneeRepository, EntityManagerInterface $entityManager,$id): Response
    {
        $reservationRon = new ReservationRon();
        $form = $this->createForm(ReservationRonType::class, $reservationRon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRon->setIdUser($this->getUser());
            $reservationRon->setIdron($randonneeRepository->find($id));
            $entityManager->persist($reservationRon);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_ron_participation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_ron/new.html.twig', [
            'reservation_ron' => $reservationRon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_ron_show", methods={"GET"})
     */
    public function show(ReservationRon $reservationRon): Response
    {
        return $this->render('reservation_ron/show.html.twig', [
            'reservation_ron' => $reservationRon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_ron_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ReservationRon $reservationRon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationRonType::class, $reservationRon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('reservation_ron_participation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_ron/edit.html.twig', [
            'reservation_ron' => $reservationRon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="reservation_ron_delete")
     */
    public function delete(Request $request,$id, ReservationRon $reservationRon, EntityManagerInterface $entityManager): Response
    {
        $em = $this->getDoctrine()->getManager();
        $reservationRon = $em->getRepository(ReservationRon::class)->find($id);
        $em->remove($reservationRon);
        $em->flush();
        return $this->redirectToRoute('reservation_ron_participation');
    }
}
