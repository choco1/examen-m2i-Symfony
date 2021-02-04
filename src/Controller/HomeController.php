<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Stagiaire;
use App\Form\CompetenceType;
use App\Form\StagiaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @param Request $request
     * @return Response
     * @Route("/addCompetence", name="add_competence")
     */
    public function createCompetence(Request $request): Response
    {
        $competence = new Competence();
        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();

            $this->addFlash('success', 'Votre competence '.$competence->getId().' a bien été ajoutée');

            return $this->redirectToRoute('home');
        }

        return   $this->render('home/createCompetence.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @param Request $request
     * @return Response
     * @Route("/home/addStagiaire", name="add_stagiaire")
     */
    public function createStagiaire(Request $request): Response
    {
        $stagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stagiaire);
            $entityManager->flush();

            $this->addFlash('success', 'Votre competence '.$stagiaire->getId().' a bien été ajoutée');

            return $this->redirectToRoute('home');
        }

        return   $this->render('home/createStagiaire.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @return Response
     * @Route("/home/allStagiaires", name="all_stagiaires")
     */
    public function listStagiaire(): Response
    {

        $repo = $this->getDoctrine()->getRepository(Stagiaire::class);
        $stagiairesCompetence = $repo->selectCompetence();
        $stagiaires = $repo->findAll();


        return $this->render('home/allStagiaire.html.twig', [
            'stagiaires' => $stagiaires,
            'stagiairesCompetences' => $stagiairesCompetence
        ]);
    }

}
