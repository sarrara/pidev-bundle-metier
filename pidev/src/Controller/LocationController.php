<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\LocationRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/location")
 */
class LocationController extends AbstractController
{

    /**
     * @Route("/mesLocation", name="location_user", methods={"GET"})
     */
    public function indexuser(LocationRepository $locationRepository): Response
    {
        return $this->render('location/indexUser.html.twig', [
            'locations' => $locationRepository->findBy(array('idUser'=>$this->getUser())),
        ]);
    }

    /**
     * @Route("/", name="location_index", methods={"GET"})
     */
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('location/index.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="location_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,$id, ProduitRepository $produitRepository): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);
        $produit = $produitRepository->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setStock($produit->getStock()-$location->getQuantite());
            $location->setIdUser($this->getUser());
            $location->setIdProduit($produit);
            $entityManager->persist($produit);
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('location_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('location/new.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
            'produit'=>$produit
        ]);
    }

    /**
     * @Route("/{id}", name="location_show", methods={"GET"})
     */
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="location_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Location $location, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('location_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('location/edit.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("delete/{id}", name="location_delete")
     */
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Location::class)->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('location_user');
    }
}
