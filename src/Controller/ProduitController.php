<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitFormType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function produit(Request $request , EntityManagerInterface  $em, ProduitRepository $repo): Response
    {
        $course = new Produit();
        $produit = $repo->findAll();

        $formCourse = $this->createForm(ProduitFormType::class,$course);
        $formCourse->handleRequest($request);

        if ($formCourse->isSubmitted())
        {
            
            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('home');

        }

        return $this->render('produit/home.html.twig',
        [ 'formCourse' => $formCourse->createView(),
            'produit' => $produit
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Produit $produit, EntityManagerInterface $em ): Response
    {
        $em->remove($produit);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/valider/{id}", name="valider")
     */
    public function valider(Produit $produit, EntityManagerInterface $em ): Response
    {
        $produit->setIsValid(true);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    
}
