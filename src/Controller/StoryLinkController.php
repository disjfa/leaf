<?php

namespace App\Controller;

use App\Entity\StoryLink;
use App\Entity\StoryPage;
use App\Form\Type\StoryLinkType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("story-link")
 */
class StoryLinkController extends AbstractController
{
    /**
     * @Route("/create/{storyPage}", name="disjfa_story_link_story_create")
     *
     * @param Request   $request
     * @param StoryPage $storyPage
     *
     * @return Response
     *
     * @throws Exception
     */
    public function create(Request $request, StoryPage $storyPage)
    {
        $storyLink = new StoryLink($storyPage);
        $form = $this->createForm(StoryLinkType::class, $storyLink);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($storyLink);
            $entityManager->flush();

            return $this->redirectToRoute('disjfa_story_page_story_show', [
                'storyPage' => $storyLink->getStoryPage()->getId(),
            ]);
        }

        return $this->render('story-link/form.html.twig', [
            'form' => $form->createView(),
            'storyPage' => $storyPage,
        ]);
    }
}
