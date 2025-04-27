<?php

namespace App\Controller;

use App\Entity\LieuNaissances;
use App\Form\LieuNaissancesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use App\Repository\LieuNaissancesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/lieu/naissances')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]

final class LieuNaissancesController extends AbstractController
{
    #[Route(name: 'app_lieu_naissances_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'], public: true, maxage: 3600)] // Met en cache le rendu complet de la page
    public function index(LieuNaissancesRepository $lieuNaissancesRepository, CacheInterface $cache): Response
    {
        $lieux = $cache->get('lieu_naissances_list', function (ItemInterface $item) use ($lieuNaissancesRepository) {
            $item->expiresAfter(3600); // Cache pendant 1 heure

            $results = $lieuNaissancesRepository->findByAll();
            // 🔥 Transformation en tableau simple :
                $data = [];
                foreach ($results as $lieu) {
                    $data[] = [
                        'id' => $lieu->getId(),
                        'commune' => $lieu->getCommune(),
                        'cercle' => $lieu->getCommune()->getCercle(),
                        'region' => $lieu->getCommune()->getCercle()->getRegion(),
                        'designation' => $lieu->getDesignation(),
                    ];
                }
            
            // On va chercher les lieux de naissance en BDD seulement si pas encore en cache
            return $data;
        });

        return $this->render('lieu_naissances/index.html.twig', [
            'lieu_naissances' => $lieux,
        ]);
    }

    #[Route('/new', name: 'app_lieu_naissances_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lieuNaissance = new LieuNaissances();
        $form = $this->createForm(LieuNaissancesType::class, $lieuNaissance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lieuNaissance);
            $entityManager->flush();

            return $this->redirectToRoute('app_lieu_naissances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lieu_naissances/new.html.twig', [
            'lieu_naissance' => $lieuNaissance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lieu_naissances_show', methods: ['GET'])]
    public function show(LieuNaissances $lieuNaissance): Response
    {
        return $this->render('lieu_naissances/show.html.twig', [
            'lieu_naissance' => $lieuNaissance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lieu_naissances_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LieuNaissances $lieuNaissance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LieuNaissancesType::class, $lieuNaissance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lieu_naissances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lieu_naissances/edit.html.twig', [
            'lieu_naissance' => $lieuNaissance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lieu_naissances_delete', methods: ['POST'])]
    public function delete(Request $request, LieuNaissances $lieuNaissance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lieuNaissance->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($lieuNaissance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lieu_naissances_index', [], Response::HTTP_SEE_OTHER);
    }
}
