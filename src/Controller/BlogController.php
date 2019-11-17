<?php


namespace App\Controller;

use App\Repository\MicroPostRepository;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * @Route("/blog")
 */
class BlogController
{
    /**
     * @Route("/", name="post_index")
     */
    public function index(Environment $twig, MicroPostRepository $microPostRepository, EntityManagerInterface $entityManager)
    {
        $sm = $entityManager->getConnection()->getSchemaManager();
        dump($sm, array_map(function (Table $table){
            return $table->getName();
        }, $sm->listTables())); die;

        return new Response($twig->render('blog/index.html.twig', [
            'posts' => $microPostRepository->findAll(),
        ]));
    }

    /**
     * @Route("/add", name="post_add")
     */
    public function add(UrlGeneratorInterface $router)
    {
        

        return new RedirectResponse($router->generate('post_index'));
    }

    /**
     * @Route("/reset", name="post_reset")
     */
    public function reset(SessionInterface $session, UrlGeneratorInterface $router)
    {
        $session->set('posts', []);

        return new RedirectResponse($router->generate('post_index'));
    }

    /**
     * @Route("/show/{id}", name="post_show")
     */
    public function show(SessionInterface $session, Environment $twig, $id)
    {
        $posts = $session->get('posts', []);
        if (!isset($posts[$id])) {
            throw new NotFoundHttpException('Post not found!');
        }

        return new Response($twig->render('blog/show.html.twig', [
            'id' => $id,
            'post' => $posts[$id],
        ]));
    }

}