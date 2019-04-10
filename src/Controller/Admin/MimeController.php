<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Inky\InkyExtension;

/**
 * @Route("/admin/mime")
 */
class MimeController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * MimeController constructor.
     *
     * @param Environment $twig
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/")
     */
    public function index()
    {
//        $string = '{% filter inky %}<container><row><columns>Hello {{ name }} {{ AA}}</columns></row></container>{% endfilter %}';
//        preg_match_all("/{{\s*(\w+)\s*}}/", $string, $matches);
//        $map = array_fill_keys($matches[1], '');
//        $template = $this->twig->createTemplate($string);

        $data = array_merge([
            'name' => 'World',
            'AA' => 'asdas',
            'style' => file_get_contents($this->getParameter('kernel.project_dir') . '/public' . $this->twig->getExtension(AssetExtension::class)->getAssetUrl('build/email.css')),
        ]);
//        dump($this->render('admin/mime/email.html.twig', $data)->getContent());
//        exit;
        return $this->render('admin/mime/email.html.twig', $data);

        $email = new Email();
        $email->html('<b>Hello world</b>');
        $email->from(new Address('disjfa@disjfa.nl'));
        dump($email->toString());
        exit;
    }
}
