<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PhotothequeController extends AbstractController
{
    #[Route('/', name: 'app_phototheque')]
    public function index(Request $request): Response
    {
        //Finder qui servira de modèle
        $finder = new Finder();
        $dossiers = $finder->directories()->in("Photos");

        //créer un formulaire
        $form = $this->createFormBuilder()
            ->add("nomDuDossier", TextType::class, ["label" => "Nom du dossier"])
            ->add("ajouter", SubmitType::class, ["label" => "Ajouter"])
            ->getForm();

        //gestion du retour de formulaire en POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //je récupère les données
            $data = $form->getData();
            //je vais chercher le nomDuDossier dedans
            $nomDuDossier = $data['nomDuDossier'];
            //il faudrait nettoyer le nom de dossier au cas où, mais on
            //va pas le faire pour gagner du temps
            $fs = new Filesystem();
            $fs->mkdir("Photos/$nomDuDossier");

            //on redirige vers la visualisation du dossier
            return $this->redirectToRoute('app_dossier',
                ['nomDuDossier' => $nomDuDossier]);
        }

        //j'appelle la vue en fournissant le modèle
        return $this->render('phototheque/index.html.twig', [
            "dossiers" => $dossiers,
            "formulaire" => $form,
        ]);
    }

    #[Route('/dossier/{nomDuDossier}', name: 'app_dossier')]
    public function dossier(string $nomDuDossier): Response
    {
        $finder = new Finder();
        $fichiers = $finder->files()->in("Photos/$nomDuDossier");

        $form=$this->createFormBuilder()
            ->add("fichier", FileType::class, ["label" => "Votre chaton"])
            ->add("ajouter", SubmitType::class, ["label" => "Ajouter"])
            ->getForm();

        //j'appelle la vue en fournissant le modèle
        return $this->render('phototheque/dossier.html.twig', [
            "fichiers" => $fichiers,
            "nomDuDossier" => $nomDuDossier,
        ]);
    }
}
