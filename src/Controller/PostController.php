<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PostController extends Controller
{
    /**
     * @Route("/post", name="post")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index(PostRepository $postRepository)
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }
}
