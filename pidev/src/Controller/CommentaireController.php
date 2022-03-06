<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="commentaire_index", methods={"GET"})
     */
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commentaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }


    function filterwords($text){
        $filterWords = array('fuck', 'pute','bitch');
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }

    /**
     * @Route("/{id}/edit/{ida}", name="commentaire_edit", methods={"GET", "POST"})
     */
    public function edit(ArticleRepository $articleRepository,CommentaireRepository $commentaireRepository,Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager,$ida): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $commentaires = $commentaireRepository->findBy(array('idArticle'=>$articleRepository->find($ida)));


        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setCommentaire($this->filterwords($commentaire->getCommentaire()));
            $entityManager->flush();

            return $this->redirectToRoute('details_article', ['id' => $ida], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/DetailsArticle.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
            'article' => $articleRepository->find($ida),
            'commantaires' =>$commentaires,
            'user'=>$this->getUser()

        ]);
    }

    /**
     * @Route("/delete/{ida}/{id}", name="commentaire_delete")
     */
    public function delete($id,$ida): Response
    {
        $em = $this->getDoctrine()->getManager();
        $activite = $em->getRepository(Commentaire::class)->find($ida);
        $em->remove($activite);
        $em->flush();
        return $this->redirectToRoute('details_article', ['id' => $id]);
    }
}
