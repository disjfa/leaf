<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("daylight")
 */
class DaylightController extends Controller
{
    /**
     * @Route("/", name="daylight_index")
     */
    public function index(Request $request)
    {
        $date = new \DateTime('now');

        dump($request->getClientIp());

        $sunInfo = date_sun_info($date->getTimestamp(), 52.132633, 5.291266);
        dump($sunInfo);
        dump($date->setTimestamp($sunInfo['sunrise']));
        dump($date->setTimestamp($sunInfo['sunset']));
        dump('a');
        exit;
    }
}
