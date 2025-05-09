<?php

namespace App\Controller;

use App\Entity\Cercles;
use App\Form\CerclesType;
use App\Repository\CerclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/cercles')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class CerclesController extends AbstractController
{
    #[Route(name: 'app_cercles_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'], public: true, maxage: 3600)] // Met en cache le rendu complet de la page
    public function index(CerclesRepository $cerclesRepository, CacheInterface $cache): Response
    {
        //$cache->delete('cercles_list'); // Supprime le cache si besoin
        $cercles = $cache->get('cercles_list', function (ItemInterface $item) use ($cerclesRepository) {
            $item->expiresAfter(3600); // Cache pendant 1 heure

            $results = $cerclesRepository->findByAll();
            // 🔥 Transformation en tableau simple 
            $data = [];
            foreach ($results as $cercle) {
                $data[] = [
                    'id' => $cercle->getId(),
                    'region' => $cercle->getRegion(),
                    'designation' => $cercle->getDesignation(),
                ];
            }

            // On va chercher les cercles en BDD seulement si pas encore en cache
            return $data;
        });

        return $this->render('cercles/index.html.twig', [
            'cercles' => $cercles,
        ]);
    }

    #[Route('/new', name: 'app_cercles_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'], public: true, maxage: 3600)] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cercle = new Cercles();
        $form = $this->createForm(CerclesType::class, $cercle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cercle);
            $entityManager->flush();

            return $this->redirectToRoute('app_cercles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cercles/new.html.twig', [
            'cercle' => $cercle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cercles_show', methods: ['GET'])]
    public function show(Cercles $cercle): Response
    {
        return $this->render('cercles/show.html.twig', [
            'cercle' => $cercle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cercles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cercles $cercle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CerclesType::class, $cercle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cercles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cercles/edit.html.twig', [
            'cercle' => $cercle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cercles_delete', methods: ['POST'])]
    public function delete(Request $request, Cercles $cercle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cercle->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cercle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cercles_index', [], Response::HTTP_SEE_OTHER);
    }
}
