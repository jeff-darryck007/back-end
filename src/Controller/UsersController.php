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


    // MODIFIER UN UTILISATEUR
    #[Route('/update_user/{id}', name: 'app_user_update', methods: ['PUT', 'PATCH'])]
    public function update(
        int $id,
        Request $request,
        UsersRepository $userRepository,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        // Récupérer l'utilisateur à modifier
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Décoder les données JSON
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Corps de requête invalide'], 400);
        }

        // Mise à jour des champs si présents
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        if (isset($data['name'])) {
            $user->setName($data['name']);
        }

        if (isset($data['surname'])) {
            $user->setSurname($data['surname']);
        }

        if (isset($data['role'])) {
            $user->setRole($data['role']);
        }

        if (isset($data['picture'])) {
            $user->setPicture($data['picture']);
        }

        if (isset($data['credit'])) {
            $user->setCredit($data['credit']);
        }

        if (isset($data['status'])) {
            $user->setStatus($data['status']);
        }

        // Si un mot de passe est envoyé, on le hashe avant de le sauvegarder
        if (isset($data['password']) && !empty($data['password'])) {
            //$hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
            //$user->setPassword($hashedPassword);
            $user->setPassword($data['password']); // comme dans ta méthode create()
        }

        // Mettre à jour la date de modification si tu as ce champ
        if (method_exists($user, 'setUpdatedAt')) {
            $user->setUpdatedAt(new \DateTime());
        }

        // Sauvegarder les modifications
        $em->persist($user);
        $em->flush();

        // Réponse JSON
        return $this->json([
            'message' => 'Utilisateur modifié avec succès',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'name' => $user->getName(),
                'surname' => $user->getSurname(),
                'role' => $user->getRole(),
                'status' => $user->getStatus(),
                'credit' => $user->getCredit(),
            ]
        ], 200);
    }



    // SUPPRIMER UN UTILISATEUR
    #[Route('/delete_user/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    public function delete(
        int $id,
        UsersRepository $userRepository,
        EntityManagerInterface $em
    ): JsonResponse {
        // Récupérer l'utilisateur
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Suppression
        $em->remove($user);
        $em->flush();

        // Réponse JSON
        return $this->json([
            'message' => 'Utilisateur supprimé avec succès',
            'id' => $id
        ], 200);
    }



    // MODIFIER LE STATUS D'UN UTILISATEUR
    #[Route('/update_status/{id}', name: 'app_user_update_status', methods: ['PATCH'])]
    public function updateStatus(
        int $id,
        Request $request,
        UsersRepository $userRepository,
        EntityManagerInterface $em
    ): JsonResponse {
        // Récupérer l'utilisateur
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Décoder le JSON
        $data = json_decode($request->getContent(), true);

        if (!isset($data['status'])) {
            return $this->json(['error' => 'Paramètre status manquant'], 400);
        }

        // Mettre à jour le status
        $user->setStatus($data['status']);

        // Sauvegarder
        $em->persist($user);
        $em->flush();

        return $this->json([
            'message' => 'Status modifié avec succès',
            'user' => [
                'id' => $user->getId(),
                'status' => $user->getStatus()
            ]
        ], 200);
    }


}
