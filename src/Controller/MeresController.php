<?php

namespace App\Controller;

use App\Entity\Meres;
use App\Form\MeresType;
use App\Repository\MeresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/meres')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class MeresController extends AbstractController
{
    #[Route(name: 'app_meres_index', methods: ['GET'])]
    public function index(MeresRepository $meresRepository, CacheInterface $cache): Response
    {
        //$cache->delete('meres_list'); // Supprime le cache avant de le recréer
        $meres = $cache->get('meres_list', function (ItemInterface $item) use ($meresRepository) {
            $item->expiresAfter(3600); // Cache pendant 1 heure
            // On va chercher les cercles en BDD seulement si pas encore en cache

            $results = $meresRepository->findByAll();
            // 🔥 Transformation en tableau simple
            $data = [];
            foreach ($results as $mere) {
                $data[] = [
                    'id' => $mere->getId(),
                    'fullname' => $mere->getFullname(),
                    'profession' => $mere->getProfession(),
                    'telephone1' => $mere->getTelephone1(),
                    'telephone2' => $mere->getTelephone2(),
                    'email' => $mere->getEmail(),
                ];
            }
            return $data;

        });


        return $this->render('meres/index.html.twig', [
            'meres' => $meres,
        ]);
    }

    #[Route('/new', name: 'app_meres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mere = new Meres();
        $form = $this->createForm(MeresType::class, $mere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mere);
            $entityManager->flush();

            return $this->redirectToRoute('app_meres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meres/new.html.twig', [
            'mere' => $mere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meres_show', methods: ['GET'])]
    public function show(Meres $mere): Response
    {
        return $this->render('meres/show.html.twig', [
            'mere' => $mere,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_meres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meres $mere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeresType::class, $mere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_meres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meres/edit.html.twig', [
            'mere' => $mere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meres_delete', methods: ['POST'])]
    public function delete(Request $request, Meres $mere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mere->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($mere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_meres_index', [], Response::HTTP_SEE_OTHER);
    }
}
