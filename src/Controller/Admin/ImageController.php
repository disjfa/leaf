<?php

namespace App\Controller\Admin;

use Disjfa\MediaBundle\Entity\Media;
use GuzzleHttp\Psr7\Uri;
use Imagine\Filter\Basic\Crop;
use Imagine\Filter\Basic\Resize;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Imagine\Image\Point;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/image")
 */
class ImageController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $files = $this->getDoctrine()->getRepository(Media::class)->findAll();
        shuffle($files);
        $file = current($files);
        /** @var Media $file */
        $uri = new Uri($file->getUrl());
        $ima = new Imagine();
        $file = new File(trim($uri->getPath(), '/'));

        $image = $ima->open(trim($uri->getPath(), '/'));
        $size = $image->getSize();
        $box = new Box(200, 200);
        $size = $this->fillBox($size, $box);

        // define filters
        $resize = new Resize($size);
        $origin = new Point(
            floor(($size->getWidth() - $box->getWidth()) / 2),
            floor(($size->getHeight() - $box->getHeight()) / 2)
        );
        $crop = new Crop($origin, $box);
        // apply filters to image
        $image = $resize->apply($image);
        $image = $crop->apply($image);
        $image->show($file->getExtension());
    }

    /**
     * @param BoxInterface $sourceBox
     * @param BoxInterface $targetBox
     *
     * @return BoxInterface
     */
    private function fillBox(BoxInterface $sourceBox, BoxInterface $targetBox)
    {
        $sourceAspect = $sourceBox->getWidth() / $sourceBox->getHeight();
        $targetAspect = $targetBox->getWidth() / $targetBox->getHeight();

        if ($sourceAspect > $targetAspect) {
            return $sourceBox->heighten($targetBox->getHeight());
        }

        return $sourceBox->widen($targetBox->getWidth());
    }
}
