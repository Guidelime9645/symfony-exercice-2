<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Episode;
use App\Entity\Season;
use App\Form\ProgramSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{    /**
    * @Route("/", name="index")
    *@return Response A reponse instance
     */
    public function index(Request $request): Response
    {
        $data = false;


        $form = $this->createForm(
            ProgramSearchType::class
        );
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
        }


        if (!$data) {
            $programs = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findAll();
        } else {
            $programs = $this->getDoctrine()
                ->getRepository(Program::class)
                ->searchProgram($data["searchField"]);
        }



        /*if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }*/

        return $this->render('wild/index.html.twig', [
            'programs' => $programs,
            'form' => $form->createView(),
            'data' => $data["searchField"],
        ]);
    }
    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function show(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $title = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($title)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }
    /**
     * Getting programs with a formatted slug for category
     * @Route("/wild/category/{categoryName}", requirements={"categoryName"="^[0-9a-z-]+$"}, defaults={"categoryName": null}, name="show_category")
     * @param string $categoryName The category
     * @return Response A category
     */
    public function showByCategory(string $categoryName) :Response
    {
        if (!$categoryName) {
            throw $this->createNotFoundException('No category has been sent to find programs in program\'s table.');
        }
        $categoryName = preg_replace(
            '/-/',
            ' ', trim(strip_tags($categoryName))
        );
        $category =$this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(
                ['name'=>mb_strtolower($categoryName)]
            );
        if (!$category)
        {
            throw $this->createNotFoundException('No category found in categories table.');
        }
        $programs=$this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category'=>$category->getId()],
                ['id' => 'desc'], 3, 0);
        return $this->render('wild/category.html.twig', [
            'category' => $category,'programs'=>$programs,
        ]);
    }
    public function index1() :Response
    {
        return $this->render('wild/show1.html.twig');
    }

    /**
     * @Route("/program/{programTitle<^[a-z0-9-]+$>}", name="program")
     * @return Response A response instance
     */
    public function showByProgram(string $programTitle)
    {
        $programTitle = preg_replace(
            '/-/',
            ' ',
            ucwords(trim(strip_tags($programTitle)), "-")
        );


        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['title' => $programTitle]);

        $seasons = $this->getDoctrine()->getRepository(Season::class)->findBy(['program_id' => $program]);

        /*if (!$seasons) {
            throw $this->createNotFoundException(
                'No season found in season\'s table.'
            );
        }*/


        return $this->render('wild/program.html.twig', [
            'seasons' => $seasons,
            'programTitle' => $programTitle,
            'program' => $program,
        ]);
    }
    /**
     * @Route("/season/{id<^[0-9]+$>}", name="season")
     * @return Response A response instance
     */
    public function showBySeason(int $id)
    {

        $season = $this->getDoctrine()->getRepository(Season::class)->findOneBy(['id' => $id]);
        return $this->render('wild/season.html.twig', [
            'season' => $season,
        ]);
    }

    /**
     * @Route("/episode/{id<^[0-9]+$>}", name="episode")
     * @return Response A response instance
     */
    public function showByEpisode(int $id)
    {

        $episode = $this->getDoctrine()->getRepository(Episode::class)->findOneBy(['id' => $id]);
        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
        ]);
    }
}
