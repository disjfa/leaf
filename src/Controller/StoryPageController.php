<?php

namespace App\Controller;

use App\Entity\Story;
use App\Entity\StoryPage;
use App\Form\Type\StoryPageType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("story-page")
 */
class StoryPageController extends AbstractController
{
    /**
     * @Route("/create/{story}", name="disjfa_story_page_story_create")
     *
     * @param Request $request
     * @param Story   $story
     *
     * @return Response
     *
     * @throws Exception
     */
    public function create(Request $request, Story $story)
    {
        $storyPage = new StoryPage($story);
        $form = $this->createForm(StoryPageType::class, $storyPage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($storyPage);
            $entityManager->flush();

            return $this->redirectToRoute('disjfa_story_page_story_show', [
                'storyPage' => $storyPage->getId(),
            ]);
        }

        return $this->render('story-page/form.html.twig', [
            'form' => $form->createView(),
            'story' => $story,
        ]);
    }

    /**
     * @Route("/{storyPage}/show", name="disjfa_story_page_story_show")
     *
     * @param StoryPage $storyPage
     *
     * @return Response
     */
    public function show(StoryPage $storyPage)
    {
        return $this->render('story-page/show.html.twig', [
            'storyPage' => $storyPage,
        ]);
    }
}
