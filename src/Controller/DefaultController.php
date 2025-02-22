<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('default/blog-create', name: 'blog-create')]
    public function blogCreate(EntityManagerInterface $em): Response
    {
        $blog = new Blog();
        $blog->setTitle('Blog title')->setDescription('Description')->setText('Text');

        $em->persist($blog);
        $em->flush();

        return $this->render('default/blog-create.html.twig');
    }

    #[Route('default/blog-find', name: 'blog-find')]
    public function blogFind(BlogRepository $blogRepository)
    {
        $blogs = $blogRepository->findAll();
        return $this->render('default/blog-find.html.twig', [
            'blogs' => $blogs
        ]);
    }

    #[Route('default/blog-change', name: 'blog-change')]
    public function blogChange(BlogRepository $blogRepository, EntityManagerInterface $em): Response
    {
        $blog = $blogRepository->findOneBy(['id' => 1]);
        if (!empty($blog)) {
            $blog->setTitle('Some tittle');
            $em->flush();

            // $em->refresh($blog); // Обновить сущность из БД
        }

        return $this->render('default/blog-change.html.twig', [
            'blog' => $blog
        ]);
    }

    #[Route('default/blog-remove', name: 'blog-remove')]
    public function blogRemove(BlogRepository $blogRepository, EntityManagerInterface $em): Response
    {
        $blogId = null;
        $blog = $blogRepository->findOneBy(['id' => 10]);
        if (!empty($blog)) {
            $blogId = $blog->getId();
            $em->remove($blog);
        }

        return $this->render('default/blog-remove.html.twig', [
            'blogId' => $blogId
        ]);
    }
}
