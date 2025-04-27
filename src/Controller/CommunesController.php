<?php

namespace App\Controller;

use App\Entity\Communes;
use App\Form\CommunesType;
use App\Repository\CommunesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/communes')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class CommunesController extends AbstractController
{
    #[Route(name: 'app_communes_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'], public: true, maxage: 3600)] // Met en cache le rendu complet de la page
    public function index(CommunesRepository $communesRepository, CacheInterface $cache): Response
    {
        $communes = $cache->get('communes_list', function (ItemInterface $item) use ($communesRepository) {
            $item->expiresAfter(3600); // Cache pendant 1 heure

            $results = $communesRepository->findByAll();
            // 🔥 Transformation en tableau simple :
            $data = [];
            foreach ($results as $commune) {
                $data[] = [
                    'id' => $commune->getId(),
                    'cercle' => $commune->getCercle(),
                    'region' => $commune->getCercle()->getRegion(),
                    'designation' => $commune->getDesignation(),
                ];
            }

            // On va chercher les communes en BDD seulement si pas encore en cache
            return $data;
        });

        return $this->render('communes/index.html.twig', [
            'communes' => $communes,
        ]);
    }

    #[Route('/new', name: 'app_communes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commune = new Communes();
        $form = $this->createForm(CommunesType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commune);
            $entityManager->flush();

            return $this->redirectToRoute('app_communes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('communes/new.html.twig', [
            'commune' => $commune,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_communes_show', methods: ['GET'])]
    public function show(Communes $commune): Response
    {
        return $this->render('communes/show.html.twig', [
            'commune' => $commune,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_communes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Communes $commune, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommunesType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_communes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('communes/edit.html.twig', [
            'commune' => $commune,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_communes_delete', methods: ['POST'])]
    public function delete(Request $request, Communes $commune, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commune->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($commune);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_communes_index', [], Response::HTTP_SEE_OTHER);
    }
}
