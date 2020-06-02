<?php
// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/wild", name="wild_")
 */

class WildController extends AbstractController
{    /**
    * @Route("/", name="index")
     */
    public function index() :Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }
    /**
     * @Route("/show/{slug}", requirements={"slug"="[a-z0-9-]+"}) , name="show")
     */
    public function show(string $slug): Response
    {

            $slug = str_replace("-", " ", $slug);
            $slug = ucwords(strtolower($slug));
            return $this->render('wild/show.html.twig', ['slug' => $slug]);
        }


    /**
     * @Route("/show/",  name="test")
     */
    public function index1() :Response
    {
        return $this->render('wild/show1.html.twig');
    }
}
