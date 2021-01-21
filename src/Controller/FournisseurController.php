<?php

namespace App\Controller;

use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Fournisseur;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class FournisseurController extends AbstractController
{
    /**
	* @var ClientRepository
	*/
	private $repository;

	/**
	* @var Environment
	*/
	private $twig;
	public function __construct(Environment $twig, FournisseurRepository $repository){
		$this->twig=$twig;
		$this->repository=$repository;
    }
    
    /**
     * @Route("/fournisseur", name="fournisseur")
     */
    public function index(): Response
    {
        return $this->render('fournisseur/fournisseurs.html.twig', [
            'controller_name' => 'FournisseurController',
        ]);
    }
    
 /**
	*@Route("/listeclients", name="listeclients")
	*@return Response
	*/
	public function listefournisseurs(Request $request): Response
	{
        //traitement
            //On récupère les donnée du formulaire après avoir validé
         $user=new Fournisseur();
            //On va créer le formulaire pour saisir les champs de l'entité Fournisseur (table fournisseur)
		  $form=$this->createFormBuilder($user)
          ->add('nom',TextType::class)
          ->add('prenom',TextType::class)
          ->add('adresse',TextType::class)
          ->add('codePostal',TextType::class)
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
        return $this->render('fournisseur/listeFournisseurs.html.twig',['current_menu'=>'listefournisseurs','properties'=>$properties]);
         }
            //On affiche le formulaire
           return $this->render('form.html.twig',['form'=>$form->createView()]);
        
	}

     /**
	*@Route("/fournisseur/{id}", name="client")
	*@return Response
	*/
	public function fournisseur($id): Response
	{
                //traitement
                $property=$this->repository->find($id);
        return $this->render('fournisseur/fournisseurs.html.twig',['current_menu'=>'listefournisseur','property'=>$property]);
	}

}
