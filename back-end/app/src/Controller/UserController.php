<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/user')]
class UserController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    // ------------------- INSCRIPTION (signUp.html/js) -------------------
#[Route('', name: 'create_user', methods: ['POST'])]
public function create(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $email = $data['email'] ?? null;
    $pseudo = $data['pseudo'] ?? null;
    $password = $data['password'] ?? null;

    if (!$email || !$pseudo || !$password) {
        return new JsonResponse([
            'success' => false,
            'message' => 'Email, pseudo et mot de passe sont requis'
        ], 400);
    }

    // Vérifier si l'email existe déjà
    $existingEmail = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
    if ($existingEmail) {
        return new JsonResponse([
            'success' => false,
            'message' => 'Cet email est déjà utilisé'
        ], 409);
    }

    // Vérifier si le pseudo existe déjà
    $existingPseudo = $this->em->getRepository(User::class)->findOneBy(['pseudo' => $pseudo]);
    if ($existingPseudo) {
        return new JsonResponse([
            'success' => false,
            'message' => 'Ce pseudo est déjà utilisé'
        ], 409);
    }

    // Création de l'utilisateur
    $user = new User();
    $user->setEmail($email);
    $user->setPseudo($pseudo);
    $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
    $user->setCreadits($data['creadits'] ?? 20);
    $user->setRole($data['role'] ?? 'ROLE_PASSENGER');
    $user->setCreatedAt(new \DateTime());
    $user->setStatus($data['status'] ?? 'active');

    $this->em->persist($user);
    $this->em->flush();

    return new JsonResponse([
        'success' => true,
        'message' => 'Utilisateur créé',
        'user_id' => $user->getId()
    ], 201);
}


    // ------------------- AFFICHER TOUS -------------------
    #[Route('', name: 'get_users', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $users = $this->em->getRepository(User::class)->findAll();

        $data = array_map(fn(User $u) => [
            'id' => $u->getId(),
            'pseudo' => $u->getPseudo(),
            'email' => $u->getEmail(),
            'creadits' => $u->getCreadits(),
            'role' => $u->getRole(),
            'status' => $u->getStatus(),
            'createdAt' => $u->getCreatedAt()->format('Y-m-d H:i:s')
        ], $users);

        return new JsonResponse($data);
    }

    // ------------------- AFFICHER UN SEUL -------------------
    #[Route('/{id}', name: 'get_user', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'pseudo' => $user->getPseudo(),
            'email' => $user->getEmail(),
            'creadits' => $user->getCreadits(),
            'role' => $user->getRole(),
            'status' => $user->getStatus(),
            'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }

    // ------------------- MODIFIER(profil.html/js) -------------------
    #[Route('/{id}', name: 'update_user', methods: ['POST'])]
public function update(int $id, Request $request, EntityManagerInterface $em): JsonResponse
{
    $user = $em->getRepository(User::class)->find($id);

    if (!$user) {
        return new JsonResponse([
            'success' => false,
            'message' => 'Utilisateur non trouvé'
        ], 404);
    }

    // Récupération des données (textuelles)
    $data = $request->request->all();

    if (isset($data['email'])) {$user->setEmail($data['email']);}
    if (isset($data['pseudo'])) {$user->setPseudo($data['pseudo']);}
    if (isset($data['firstName'])) {$user->setFirstName($data['firstName']);}
    if (isset($data['lastName'])) {$user->setLastName($data['lastName']);}
    if (isset($data['birthDate']) && $data['birthDate'] !== '') {
        $user->setBirthDate(new \DateTime($data['birthDate']));
    }
    if (isset($data['postalAddress'])) {$user->setPostalAddress($data['postalAddress']);}
    if (isset($data['phone'])) {$user->setPhone($data['phone']);}
    if (isset($data['password']) && $data['password'] !== '') {
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
    }

    // Gestion upload photo
    $file = $request->files->get('photo_profil');

    if ($file) {
        $fileName = uniqid() . '.' . $file->guessExtension();
        $file->move($this->getParameter('profiles_directory'), $fileName);
        $user->setProfilePhotoUrl('/uploads/profiles/' . $fileName);
    }

    $em->persist($user);
    $em->flush();

    return new JsonResponse([
        'success' => true,
        'message' => 'Profil mis à jour',
        'user' => [
            'id' => $user->getId(),
            'pseudo' => $user->getPseudo(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'birthDate' => $user->getBirthDate()?->format('Y-m-d'),
            'postalAddress' => $user->getPostalAddress(),
            'phone' => $user->getPhone(),
            'profilePhotoUrl' => $user->getProfilePhotoUrl(),
        ]
    ]);
}

    // ------------------- SUPPRIMER -------------------
    #[Route('/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $user = $this->em->getRepository(User::class)->find($id);
        if (!$user) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }

        $this->em->remove($user);
        $this->em->flush();

        return new JsonResponse(['success' => true, 'message' => 'Utilisateur supprimé']);
    }
}
