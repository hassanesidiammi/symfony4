<?php


namespace App\Controller;


use App\Services\Greeting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private $greeting;

    public function __construct(Greeting $greeting)
    {
        $this->greeting = $greeting;
    }

    /**
     *
     * @Route("/{name}", name="blog_index")
     */
    public function index(Request $request, string $name)
    {
        return $this->render('base.html.twig',[
            'message' => $this->greeting->greet($name)
        ]);
    }
}