<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

final class TestController extends AbstractController
{
    #[Route('/', name: 'phpinfo')]
    public function phpinfo(): Response
    {
        phpinfo();
        die;
    }

    #[Route('test/test-route/{id}',
        name: 'test-route',
        requirements: ['id' => '\d+'],
        defaults: ['id' => 1],
        methods: ['GET', 'POST'])
    ]
    public function testRoute(int $id): Response
    {
        $test = [1, 2, 3];
        //dd($id);
        return $this->render( 'test/test-route.html.twig', [
            'test' => $test,
            'id' => $id,
        ]);
    }

    #[Route('test/test-php-view',
        name: 'test-php-view',
        methods: ['GET', 'POST'])
    ]
    public function testPhpView(Request $request): Response
    {
        return $this->render( 'test/test-php-view.php', ['name' => 'Rom']);
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
