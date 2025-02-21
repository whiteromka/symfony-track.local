<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        // phpinfo();
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('index/test/{id}',
        name: 'test',
        requirements: ['id' => '\d+'],
        defaults: ['id' => 1],
        methods: ['GET', 'POST'])
    ]
    public function test(int $id): Response
    {
        $test = [1, 2, 3];
        //dd($id);
        return $this->render(/*'index/test.php'*/ 'index/test.html.twig', [
            'test' => $test,
            'id' => $id,
        ]);
    }

    #[Route('index/test2',
        name: 'test2',
        methods: ['GET', 'POST'])
    ]
    public function test2(Request $request): Response
    {
        dd($request);
        die;
    }


    #[Route('/team/create', name: 'create_team')]
    public function createTeam(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Создаем новый объект Team
        $team = new Team();

        // Устанавливаем имя команды (например, из запроса)
        $team->setName('My New Team');

        // Устанавливаем текущую дату для createdAt
        $team->setCreatedAt(new \DateTimeImmutable());

        // Сохраняем объект в базе данных
        $entityManager->persist($team);
        $entityManager->flush();

        return new Response('Team created with ID: ' . $team->getId());
    }
}
