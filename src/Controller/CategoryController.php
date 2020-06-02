<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/add", name="category_add")
     */
    public function add(Request $request)
    {

        $category = new Category();

        $form = $this->createForm(
            CategoryType::class,
            $category
        );
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();


            $entityManager = $this->getDoctrine()->getManager();

            $category->setName($data->getName());

            $entityManager->persist($category);

            $entityManager->flush();
            return $this->redirectToRoute('wild_index');
        }


        return $this->render('category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}