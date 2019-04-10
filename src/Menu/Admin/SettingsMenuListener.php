<?php

namespace App\Menu\Admin;

use Disjfa\MenuBundle\Menu\ConfigureMenuEvent;
use PhpMob\Settings\Schema\Section;
use PhpMob\Settings\Schema\SettingSchemaRegistry;
use Symfony\Component\Translation\TranslatorInterface;

class SettingsMenuListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var SettingSchemaRegistry
     */
    private $settingSchemaRegistry;

    /**
     * MediaMenuListener constructor.
     *
     * @param SettingSchemaRegistry $settingSchemaRegistry
     * @param TranslatorInterface   $translator
     */
    public function __construct(SettingSchemaRegistry $settingSchemaRegistry, TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->settingSchemaRegistry = $settingSchemaRegistry;
    }

    /**
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $globals = $this->settingSchemaRegistry->getGlobals();
        if (0 === count($globals)) {
            return;
        }
        $menu = $event->getMenu();

        $settings = $menu->getChild('settings');
        if (null === $settings) {
            $settings = $menu->addChild('settings', [
                'route' => 'phpmob_settings_section_update',
                'routeParameters' => ['section' => 'website'],
                'label' => $this->translator->trans('menu.settings', [], 'admin'),
            ])->setExtra('icon', 'fa-cog');
        }

        foreach ($globals as $global) {
            /* @var Section $global */
            $settings->addChild($global->getName(), [
                'route' => 'phpmob_settings_section_update',
                'routeParameters' => ['section' => $global->getName()],
                'label' => $this->translator->trans($global->getLabel(), [], 'admin'),
            ]);
        }
    }
}
