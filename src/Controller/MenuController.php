<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MenuController extends AbstractController
{
    public function _menu(): Response
    {
        //Finder qui servira de modèle
        $finder = new Finder();
        $dossiers = $finder->directories()->in("Photos");

        //j'appelle la vue en fournissant le modèle
        return $this->render('menu/_menu.html.twig', [
            "dossiers"=>$dossiers,
        ]);
    }
}
