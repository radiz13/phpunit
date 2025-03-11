<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'myApp_')]
final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $strName = null !== $request->query->get('nb') ? "Pierre Emile" : "Gérald";
        if ($request->query->get('nb') == 2) $strName = "Thierry";

        return $this->render('home/index.html.twig', [
            'user_name' => $strName
        ]);
    }

    #[Route('/2', name: 'home2')]
    public function index2(
        Request $request,
    ): Response
    {
        $strName = "Salvator";

        return $this->render('home/index2.html.twig', [
            'user_name' => $strName
        ]);
    }

    #[Route('/pic', name: 'pic')]
    public function pic(
    ): Response
    {
        sleep(2);
        return $this->render('home/pic.html.twig', []);
    }

}
