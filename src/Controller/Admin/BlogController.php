<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use App\Form\Type\BlogPostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Exception\ExceptionInterface;
use Symfony\Component\Workflow\Registry;

/**
 * @Route("/admin/blog")
 */
class BlogController extends Controller
{
    /**
     * @Route("/", name="disjfa_blog_blog_index")
     */
    public function index()
    {
        return $this->render('admin/blog/index.html.twig', [
            'blogs' => $this->getDoctrine()->getRepository(BlogPost::class)->findAll(),
        ]);
    }

    /**
     * @Route("/{blogPost}/show", name="disjfa_blog_blog_show")
     *
     * @param BlogPost $blogPost
     *
     * @return Response
     */
    public function show(BlogPost $blogPost, Registry $workflows)
    {
        $workflow = $workflows->get($blogPost);

        return $this->render('admin/blog/show.html.twig', [
            'blogPost' => $blogPost,
            'transitions' => $workflow->getEnabledTransitions($blogPost),
        ]);
    }

    /**
     * @Route("/{blogPost}/transition/{transition}", name="disjfa_blog_blog_transition")
     *
     * @param BlogPost $blogPost
     * @param string   $transition
     * @param Registry $workflows
     *
     * @return Response
     */
    public function transition(BlogPost $blogPost, string $transition, Registry $workflows)
    {
        $workflow = $workflows->get($blogPost);

        try {
            $workflow->apply($blogPost, $transition);
            $this->get('doctrine')->getManager()->flush();
        } catch (ExceptionInterface $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirectToRoute('disjfa_blog_blog_show', [
            'blogPost' => $blogPost->getId(),
        ]);
    }

    /**
     * @Route("/create", name="disjfa_blog_blog_create")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $blogPost = new BlogPost($this->getUser()->getId());
        $form = $this->createForm(BlogPostType::class, $blogPost);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blogPost);
            $entityManager->flush();

            $this->addFlash('success', 'Blog post created');

            return $this->redirectToRoute('disjfa_blog_blog_show', ['blogPost' => $blogPost->getId()]);
        }

        return $this->render('admin/blog/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{blogPost}/edit", name="disjfa_blog_blog_edit")
     *
     * @param BlogPost $blogPost
     * @param Request  $request
     *
     * @return Response
     */
    public function edit(BlogPost $blogPost, Request $request)
    {
        $form = $this->createForm(BlogPostType::class, $blogPost);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blogPost);
            $entityManager->flush();

            $this->addFlash('success', 'Blog post saved');

            return $this->redirectToRoute('disjfa_blog_blog_show', ['blogPost' => $blogPost->getId()]);
        }

        return $this->render('admin/blog/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
