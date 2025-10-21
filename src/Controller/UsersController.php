<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; // formater les reponses en json
use Symfony\Component\Routing\Attribute\Route; 
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // hascher le mot de passe
use Symfony\Component\HttpFoundation\Request; // corps de la requete
use Doctrine\ORM\EntityManagerInterface; // manipuler la base de donnees

use App\Entity\Users; // Entité utilisateur
use App\Repository\UsersRepository; // repository de l'utilisateur

final class UsersController extends AbstractController
{

    // INSERER UN UTILISATEUR
    #[Route('/insert_users', name: 'app_user_create', methods: ['POST'])]
    public function create(
        Request $request, // parametre de requete
        EntityManagerInterface $em, // declaration de l'interface
        UserPasswordHasherInterface $passwordHasher // class pour hascher le mot de passe
    ): JsonResponse {
        // Décoder les données JSON envoyées
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['email']) || !isset($data['password']) || !isset($data['name']) || !isset($data['surname']) || !isset($data['role'])) {
            return $this->json(['error' => 'Paramètres manquants'], 400);
        }

        // Créer un nouvel utilisateur
        $user = new Users();
        $user->setEmail($data['email']);
        $user->setName($data['name']);
        $user->setSurname($data['surname']);
        $user->setRole($data['role']);
        $user->setPicture(" ");
        $user->setCreateAt(new \DateTime());
        $user->setCredit(0);
        $user->setStatus(1); // Actif
        //$hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($data['password']);

        // Persister en base ici c'est inserer
        $em->persist($user);
        $em->flush(); // mettre a jour la bd

        return $this->json([
            'message' => 'Utilisateur créé avec succès',
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'surname' => $user->getSurname()
        ], 201);
    }


    // LISTE DES UTILISATEURS
    #[Route('/users', name: 'app_users', methods: ['GET'])]
    public function index(UsersRepository $userRepository): JsonResponse
    {
        // Récupération de tous les utilisateurs
        $users = $userRepository->findAll();

        // Transformation en tableau (pour JSON)
        $data = [];
        foreach ($users as $user) {
            $data["data"][] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                // ajoute d’autres champs si nécessaires
            ];
        }

        // Réponse JSON
        return $this->json([
            "success" => false, 
            "data" => $data
        ]);
    }
}
