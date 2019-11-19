<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/micro-post")
 */
class MicroPostController extends AbstractController
{
    /**
     * @Route("/", name="micro_post_index", methods={"GET"})
     */
    public function index(MicroPostRepository $microPostRepository): Response
    {
        return $this->render('blog/micro_post/index.html.twig', [
            'micro_posts' => $microPostRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="micro_post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $microPost = new MicroPost();
        $form = $this->createForm(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($microPost);
            $entityManager->flush();

            return $this->redirectToRoute('micro_post_index');
        }

        return $this->render('blog/micro_post/new.html.twig', [
            'micro_post' => $microPost,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="micro_post_show", methods={"GET"})
     */
    public function show(MicroPost $microPost): Response
    {
        return $this->render('blog/micro_post/show.html.twig', [
            'micro_post' => $microPost,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="micro_post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MicroPost $microPost): Response
    {
        $form = $this->createForm(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('micro_post_index');
        }

        return $this->render('blog/micro_post/edit.html.twig', [
            'micro_post' => $microPost,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="micro_post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MicroPost $microPost): Response
    {
        if ($this->isCsrfTokenValid('delete'.$microPost->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($microPost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('micro_post_index');
    }
}
