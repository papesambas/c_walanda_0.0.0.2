<?php

namespace App\Controller;

use App\Entity\Professions;
use App\Form\ProfessionsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProfessionsRepository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/professions')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class ProfessionsController extends AbstractController
{
    #[Route(name: 'app_professions_index', methods: ['GET'])]
    public function index(ProfessionsRepository $professionsRepository, CacheInterface $cache): Response
    {
        $professions = $cache->get('professions_list', function (ItemInterface $item) use ($professionsRepository) {
            $item->expiresAfter(3600); // Cache pendant 1 heure

            // On va chercher les cercles en BDD seulement si pas encore en cache
            return $professionsRepository->findAll();
        });

        return $this->render('professions/index.html.twig', [
            'professions' => $professions,
        ]);
    }

    #[Route('/new', name: 'app_professions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $profession = new Professions();
        $form = $this->createForm(ProfessionsType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($profession);
            $entityManager->flush();

            return $this->redirectToRoute('app_professions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professions/new.html.twig', [
            'profession' => $profession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professions_show', methods: ['GET'])]
    public function show(Professions $profession): Response
    {
        return $this->render('professions/show.html.twig', [
            'profession' => $profession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professions $profession, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfessionsType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_professions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professions/edit.html.twig', [
            'profession' => $profession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professions_delete', methods: ['POST'])]
    public function delete(Request $request, Professions $profession, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profession->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($profession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_professions_index', [], Response::HTTP_SEE_OTHER);
    }
}
