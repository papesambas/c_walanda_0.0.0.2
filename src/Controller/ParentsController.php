<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Parents;
use App\Form\ParentsType;
use App\Data\SearchParentData;
use App\Form\SearchParentDataType;
use App\Repository\MeresRepository;
use App\Repository\PeresRepository;
use App\Repository\ParentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/parents')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class ParentsController extends AbstractController
{
    public function __construct(private readonly Security $security)
    {
    }
    
    #[Route(name: 'app_parents_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'], public: true, maxage: 3600)] // Met en cache le rendu complet de la page
    public function index(Request $request,ParentsRepository $parentsRepository,PeresRepository
    $peresRepository,MeresRepository $meresRepository ,CacheInterface $cache): Response
    {
        $user = $user = $this->security->getUser();
        /*if ($user instanceof Users) {
            $etablissement = $user->getEtablissement();
        }
        else {
            $etablissement = null; // ou gérer le cas où l'utilisateur n'est pas connecté
        }*/
        
        $data = new SearchParentData();
        $form = $this->createForm(SearchParentDataType::class, $data);
        $form->handleRequest($request);

        // Recherche des pères et mères correspondants
        $peres = $peresRepository->findBySearchParentData($data);
        $meres = $meresRepository->findBySearchParentData($data);

        if ($form->isSubmitted() && $form->isValid() && (!empty($peres) || !empty($meres))) {
            // Recherche des parents correspondants avec tous les pères et mères trouvés
            $parents = $parentsRepository->findByPereOrMere($peres, $meres);
        } else {
            // Si aucun critère de recherche, affichez tous les parents
            $parents = $parentsRepository->findAll();
        }

        return $this->render('parents/index.html.twig', [
            'parents' => $parents,
            'form'    => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_parents_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'], public: true, maxage: 3600)] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager, PeresRepository $peresRepository, MeresRepository $meresRepository): Response
    {
        $parent = new Parents();
                // Pré-remplissage si un ID de père est transmis
                if ($request->query->has('pere_id')) {
                    $pere = $peresRepository->find($request->query->get('pere_id'));
                    if ($pere) {
                        $parent->setPere($pere);
                    } else {
                        $this->addFlash('error', 'Le père spécifié n\'existe pas.');
                        return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
                    }
                }
        
                // Pré-remplissage si un ID de mère est transmis
                if ($request->query->has('mere_id')) {
                    $mere = $meresRepository->find($request->query->get('mere_id'));
                    if ($mere) {
                        $parent->setMere($mere);
                    } else {
                        $this->addFlash('error', 'La mère spécifiée n\'existe pas.');
                        return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
                    }
                }
        
        $form = $this->createForm(ParentsType::class, $parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($parent);
                $entityManager->flush();
                
                $this->addFlash('success', 'Les informations parentales ont été enregistrées avec succès.');
                return $this->redirectToRoute('app_parents_index', ['parent_id' => $parent->getId()], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'enregistrement.');
                // Log l'erreur ici si vous avez un logger
            }        }

        return $this->render('parents/new.html.twig', [
            'parent' => $parent,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_parents_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'], public: true, maxage: 3600)] // Met en cache le rendu complet de la page
    public function show(Parents $parent): Response
    {
        return $this->render('parents/show.html.twig', [
            'parent' => $parent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parents_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parents $parent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParentsType::class, $parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parents/edit.html.twig', [
            'parent' => $parent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parents_delete', methods: ['POST'])]
    public function delete(Request $request, Parents $parent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $parent->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($parent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parents_index', [], Response::HTTP_SEE_OTHER);
    }
}
