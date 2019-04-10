<?php

namespace App\Controller;

use Faker\Documentor;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/faker")
 */
class FakerController extends Controller
{
    /**
     * @Route("/", name="faker_index")
     */
    public function index()
    {
        $generator = Factory::create('nl_NL');
        $doc = new Documentor($generator);
        dump($doc->getFormatters());
        exit;
        $tmp = [
            'firstName' => $generator->firstName,
            'lastName' => $generator->lastName,
            'languageCode' => $generator->languageCode,
            'dateTime' => $generator->dateTime,
        ];
        dump($tmp);
        exit;

        return new JsonResponse($tmp);
    }
}
