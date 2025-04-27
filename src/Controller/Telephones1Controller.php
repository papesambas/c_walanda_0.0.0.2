<?php

namespace App\Controller;

use App\Entity\Telephones1;
use App\Form\Telephones1Type;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Telephones1Repository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\Cache;


#[Route('/telephones1')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class Telephones1Controller extends AbstractController
{
    #[Route('/', name: 'app_telephones1_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'], public: true, maxage: 3600)] // Met en cache le rendu complet de la page
    public function index(Telephones1Repository $telephones1Repository, CacheInterface $cache): Response
    {
        //$cache->delete('telephones1_data'); // Supprime le cache si besoin
        $telephones1 = $cache->get('telephones1_list', function (ItemInterface $item) use ($telephones1Repository) {
            $item->expiresAfter(3600); // 1h
    
            $results = $telephones1Repository->findByAll();
    
            // 🔥 Transformation en tableau simple :
            $data = [];
            foreach ($results as $telephone) {
                $data[] = [
                    'id' => $telephone->getId(),
                    'numero' => $telephone->getNumero(),
                    'peres' => $telephone->getPeres(),
                    'meres' => $telephone->getMeres(),
                    'pere.profession' => $telephone->getPeres()?->getProfession()?->getDesignation(),
                    'mere.profession' => $telephone->getMeres()?->getProfession()?->getDesignation(),
                ];
            }
    
            return $data;
        });
    
        return $this->render('telephones1/index.html.twig', [
            'telephones1s' => $telephones1,
        ]);
    }
    
    #[Route('/new', name: 'app_telephones1_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $telephones1 = new Telephones1();
        $form = $this->createForm(Telephones1Type::class, $telephones1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($telephones1);
            $entityManager->flush();

            return $this->redirectToRoute('app_telephones1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('telephones1/new.html.twig', [
            'telephones1' => $telephones1,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_telephones1_show', methods: ['GET'])]
    public function show(Telephones1 $telephones1): Response
    {
        return $this->render('telephones1/show.html.twig', [
            'telephones1' => $telephones1,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_telephones1_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Telephones1 $telephones1, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Telephones1Type::class, $telephones1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_telephones1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('telephones1/edit.html.twig', [
            'telephones1' => $telephones1,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_telephones1_delete', methods: ['POST'])]
    public function delete(Request $request, Telephones1 $telephones1, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$telephones1->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($telephones1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_telephones1_index', [], Response::HTTP_SEE_OTHER);
    }
}
