<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/Allarticle", name="article_alll", methods={"GET"})
     */
    public function indexAllArticle(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/AllArticle.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/adminarticle", name="article_admin", methods={"GET"})
     */
    public function indexAllAdmin(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/adminindex.html.twig', [
            'articles' => $articleRepository->findAll(),
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
     * @Route("/details/{id}", name="details_article")
     */
    public function details(ArticleRepository $articleRepository,CommentaireRepository $commentaireRepository,$id,Request $request , EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $commentaires = $commentaireRepository->findBy(array('idArticle'=>$articleRepository->find($id)));


        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setCommentaire($this->filterwords($commentaire->getCommentaire()));
            $commentaire->setIdUser($this->getUser());
            $commentaire->setIdArticle($articleRepository->find($id));
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('details_article', ['id' => $id]);
        }

        return $this->render('article/DetailsArticle.html.twig', [
            'article' => $articleRepository->find($id),
            'form' => $form->createView(),
            'commantaires' =>$commentaires,
            'user'=>$this->getUser()
        ]);
    }

    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findBy(array('idUser'=>$this->getUser())),
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->getUploadFile();
            $article->setIdUser($this->getUser());
            $article->setDateEcrit(new \DateTime());
            $article->setEtat('en attent');
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($article->getFile() != null){
                $article->getUploadFile();
            }
            $entityManager->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="article_delete")
     */
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository(Article::class)->find($id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('article_index');
    }


    /**
     * @Route("/accepter/{id}", name="article_accepter", methods={"GET","POST"})
     */
    public function accepter(Request $request,  $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $article->setEtat('Accepté');
        $this->getDoctrine()->getManager()->persist($article);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('article_admin', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/refuser/{id}", name="article_refuser", methods={"GET","POST"})
     */
    public function refuser(Request $request,  $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $article->setEtat('refuser');
        $this->getDoctrine()->getManager()->persist($article);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('article_admin', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/pdf/{id}", name="article_pdf", methods={"GET","POST"})
     */
    public function articlepdf($id ,ArticleRepository $articleRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('article/mypdf.html.twig', [
            'article' => $articleRepository->find($id)
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
}
