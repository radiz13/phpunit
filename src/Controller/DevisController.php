<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\DevisDesign;
use App\Entity\Product;
use App\Form\DevisDesignType;
use App\Form\DevisType;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/devis', name: 'app_devis_')]
final class DevisController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(
        DevisRepository $devisRepository,
    ): Response
    {
        $deviss = $devisRepository->findAll();

        return $this->render('devis/index.html.twig', [
            'devis' => $deviss
        ]);
    }

    #[Route('/devis/new', name: 'app_devis_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $devis = new Devis();

        // Ajouter une désignation par défaut
        if ($request->getSession()->has('devis_designs')) {
            $designsData = $request->getSession()->get('devis_designs');
            foreach ($designsData as $designData) {
                $design = new DevisDesign();
                $design->setDesign($designData['design'] ?? '');
                $design->setQuantity($designData['quantity'] ?? 0);

                if (isset($designData['product'])) {
                    $product = $entityManager->getRepository(Product::class)->find($designData['product']);
                    if ($product) {
                        $design->setProduct($product);
                    }
                }

                $design->setDevis($devis);
                $devis->addDesign($design);
            }
        }

        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $request->getSession()->remove('devis_designs');

            $entityManager->persist($devis);
            $entityManager->flush();

            $this->addFlash('success', 'Devis créé avec succès !');
            return $this->redirectToRoute('app_devis_index');
        }

        return $this->render('devis/new.html.twig', [
            'form' => $form->createView(),
            'btnLabel' => 'Créer le devis',
            'designCount' => count($devis->getDesigns()),
        ]);
    }

    #[Route('/devis/add-design/{index}', name: 'add_design')]
    public function addDesign(
        Request $request,
        FormFactoryInterface $formFactory,
        int $index
    ): Response {
        // Récupérer les designs existants de la session
        $designsData = $request->getSession()->get('devis_designs');

        // Ajouter un nouveau design vide
        $designsData[$index] = [
            'design' => '',
            'quantity' => 1,
            'product' => null
        ];

        // Sauvegarder en session
        $request->getSession()->set('devis_designs', $designsData);

        // Créer un formulaire isolé pour ce design
        $designForm = $formFactory->createNamed(
            "devis",
            DevisDesignType::class
        );

        // Renvoyer le fragment de formulaire
        return $this->render('devis/turbo/add.html.twig', [
            'designForm' => $designForm->createView(),
            'index' => $index,
        ], new Response(null, 200, ['Content-Type' => 'text/vnd.turbo-stream.html'])
        );


    }

    #[Route('/remove-design/{index}', name: 'remove_design')]
    public function removeDesign(Request $request, int $index): Response
    {
        // Récupérer les designs existants de la session
        $designsData = $request->getSession()->get('devis_designs');
$index2 = $index - 1;
        // Supprimer le design spécifié
        if (isset($designsData[$index2])) {
            unset($designsData[$index2]);
            $designsData = array_values($designsData); // Réindexer le tableau
        }

        // Sauvegarder en session
        $request->getSession()->set('devis_designs', $designsData);

        return $this->render('devis/turbo/remove.html.twig', [
            'index' => $index,
        ], new Response(null, 200, ['Content-Type' => 'text/vnd.turbo-stream.html']));
    }
}
