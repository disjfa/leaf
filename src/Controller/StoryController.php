<?php

namespace App\Controller;

use App\Entity\Story;
use App\Form\Type\StoryType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("story")
 */
class StoryController extends AbstractController
{
    /**
     * @Route("/", name="disjfa_story_story_index")
     *
     * @return Response
     */
    public function index()
    {
        return $this->render('story/index.html.twig', [
            'stories' => $this->getDoctrine()->getRepository(Story::class)->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="disjfa_story_story_create")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws Exception
     */
    public function create(Request $request)
    {
        $story = new Story();
        $form = $this->createForm(StoryType::class, $story);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $story = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($story);
            $entityManager->flush();

            return $this->redirectToRoute('disjfa_story_story_show', [
                'story' => $story->getId(),
            ]);
        }

        return $this->render('story/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{story}/show", name="disjfa_story_story_show")
     *
     * @param Story $story
     *
     * @return Response
     */
    public function show(Story $story)
    {
        return $this->render('story/show.html.twig', [
            'story' => $story,
        ]);
    }
}
