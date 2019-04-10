<?php

namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Uri;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crawler")
 */
class CrawlerController extends Controller
{
    /**
     * @Route("/", name="crawler_index")
     */
    public function index()
    {
        $client = new Client();
        $uri = new Uri('https://www.nu.nl/');
        try {
            $response = $client->get($uri);
        } catch (ClientException $e) {
            dump($e->getResponse()->getStatusCode());
            exit;
        }

        $crawler = new Crawler($response->getBody()->getContents());
        $crawler->filter('script,style')->each(function (Crawler $crawler) {
            $node = $crawler->getNode(0);
            $node->parentNode->removeChild($node);
        });
        dump($uri->getHost());
        dump($uri->getPath());
        $tmp = explode('.', $uri->getPath());
        if ($tmp && in_array(end($tmp), ['jpg', 'jpeg', 'gif', 'png'])) {
            dump('a');
        }
        dump($uri->getScheme());
        if ($crawler->filter('h1')->count()) {
            dump(trim($crawler->filter('h1')->text()));
        }

        $html = $crawler->filter('body')->html();
        $html = preg_replace('/\</', ' <', $html);
        $html = strip_tags($html);
        $html = preg_replace('/\s+/', ' ', $html);
        $html = trim($html);
        dump($html);

        $links = $crawler->filter('a');
        $links->reduce(function (Crawler $node, $i) use ($uri) {
            $href = $node->attr('href');
            if (preg_match('/^\#/', $href)) {
                return;
            }
            if (preg_match('/^javascript/', $href)) {
                return;
            }
            if (null === $href) {
                return;
            }

            $tmp = new Uri($href);
            if ( ! $tmp->getHost()) {
                $tmp = $tmp->withHost($uri->getHost());
            }
            if ( ! $tmp->getScheme()) {
                $tmp = $tmp->withScheme($uri->getScheme());
            }
            dump($tmp->__toString());
        });

        dump('a');
        exit;
    }
}
