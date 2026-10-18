<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PhotothequeController extends AbstractController
{
    #[Route('/', name: 'app_phototheque')]
    public function index(): Response
    {
        //Finder qui servira de modèle
        $finder = new Finder();
        $dossiers = $finder->directories()->in("Photos");

        //j'appelle la vue en fournissant le modèle
        return $this->render('phototheque/index.html.twig', [
            "dossiers"=>$dossiers,
        ]);
    }

    #[Route('/dossier/{nomDuDossier}', name: 'app_dossier')]
    public function dossier(String $nomDuDossier): Response
    {
        $finder = new Finder();
        $fichiers = $finder->files()->in("Photos/$nomDuDossier");

        //j'appelle la vue en fournissant le modèle
        return $this->render('phototheque/dossier.html.twig', [
            "fichiers"=>$fichiers,
            "nomDuDossier"=>$nomDuDossier,
        ]);
    }
}
