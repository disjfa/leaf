<?php

namespace App\Menu\Site;

use Disjfa\MenuBundle\Menu\ConfigureMenuEvent;
use Symfony\Component\Translation\TranslatorInterface;

class HomeMenuListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * HomeMenuListener constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menu->addChild('home', [
            'route' => 'home_index',
            'label' => $this->translator->trans('menu.home', [], 'site'),
        ])->setExtra('icon', 'fa-home');
    }
}
