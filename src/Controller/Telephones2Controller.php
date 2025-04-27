<?php

namespace App\Controller;

use App\Entity\Telephones2;
use App\Form\Telephones2Type;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Telephones2Repository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/telephones2')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class Telephones2Controller extends AbstractController
{
    #[Route(name: 'app_telephones2_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'], public: true, maxage: 3600)]
    public function index(Telephones2Repository $telephones2Repository,CacheInterface $cache): Response
    {
        //$cache->delete('telephones1_data'); // Supprime le cache si besoin
        $telephones2 = $cache->get('telephones2_list', function (ItemInterface $item) use ($telephones2Repository) {
            $item->expiresAfter(3600); // 1h
    
            $results = $telephones2Repository->findByAll();
    
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
    
        return $this->render('telephones2/index.html.twig', [
            'telephones2s' => $telephones2,
        ]);
    }

    #[Route('/new', name: 'app_telephones2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $telephones2 = new Telephones2();
        $form = $this->createForm(Telephones2Type::class, $telephones2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($telephones2);
            $entityManager->flush();

            return $this->redirectToRoute('app_telephones2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('telephones2/new.html.twig', [
            'telephones2' => $telephones2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_telephones2_show', methods: ['GET'])]
    public function show(Telephones2 $telephones2): Response
    {
        return $this->render('telephones2/show.html.twig', [
            'telephones2' => $telephones2,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_telephones2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Telephones2 $telephones2, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Telephones2Type::class, $telephones2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_telephones2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('telephones2/edit.html.twig', [
            'telephones2' => $telephones2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_telephones2_delete', methods: ['POST'])]
    public function delete(Request $request, Telephones2 $telephones2, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$telephones2->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($telephones2);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_telephones2_index', [], Response::HTTP_SEE_OTHER);
    }
}
