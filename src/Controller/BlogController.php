<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
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
    public function index(SessionInterface $session, Environment $twig)
    {
        return new Response($twig->render('blog/index.html.twig', [
            'posts' => $session->get('posts', []),
        ]));
    }

    /**
     * @Route("/add", name="post_add")
     */
    public function add(SessionInterface $session, UrlGeneratorInterface $router)
    {
        $posts = $session->get('posts', []);
        $posts[uniqid('post')] = [
            'title' => (count($posts) + 1).' '.substr(base64_encode('title '.rand(1, 50).uniqid()), 20),
            'body' => (count($posts)).' '.base64_encode('body '.rand(10, 500).uniqid()),
        ];
        $session->set('posts', $posts);

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