<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ArticleController extends AbstractController
{
     /**
	* @var ArticleRepository
	*/
	private $repository;

	/**
	* @var Environment
	*/
	private $twig;
	public function __construct(Environment $twig, ArticleRepository $repository){
		$this->twig=$twig;
		$this->repository=$repository;
    }
    
    /**
     * @Route("/article", name="article")
     */
    public function index(): Response
    {
        return $this->render('article/articles.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

      
 /**
	*@Route("/listearticles", name="listearticles")
	*@return Response
	*/
	public function listearticles(Request $request): Response
	{
            //traitement
                //On récupère les donnée du formulaire après avoir validé
            $user=new Article();
                //On va créer le formulaire pour saisir les champs de l'entité article (table article)
            $form=$this->createFormBuilder($user)
            ->add('designation',TextType::class)
            ->add('prixht',MoneyType::class)
            ->add('quantiteht',NumberType::class)
            ->add('save',SubmitType::class)
            ->getForm();

                //On récupère les données du formulaire après avoir validé
            $form->handleRequest($request);
            //On test si le formulaire à été soumit et si il est valide
        if ($form->isSubmitted() && $form->isValid()){
                    //On recupère les données du formulaires que l'on stock dans $userInfos.
            $userInfos=$form->getData();
                
            $entityManager=$this->getDoctrine()->getManager();
                    //On enrégistre tout les données dans la table
            $entityManager->persist($userInfos);
            $entityManager->flush();
                //On récupère tous les enrégistrements de la table
            $properties=$this->repository->findAll();	
            return $this->render('article/listeArticles.html.twig',['current_menu'=>'listearticles','properties'=>$properties]);
         }
            //On affiche le formulaire
           return $this->render('form.html.twig',['form'=>$form->createView()]);
        
	}

     /**
	*@Route("/client/{id}", name="client")
	*@return Response
	*/
	public function article($id): Response
	{
                //traitement
                $property=$this->repository->find($id);
        return $this->render('client/clients.html.twig',['current_menu'=>'listearticles','property'=>$property]);
	}



}
