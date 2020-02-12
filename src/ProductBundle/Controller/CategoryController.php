<?php

namespace ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EntityBundle\Entity\Category;
use EntityBundle\Form\CategoryType;

use Symfony\Component\HttpFoundation\Request;


class CategoryController extends Controller
{
    public function ListCategoryAction(){
        $em = $this->getDoctrine()->getManager();

        $categorylist = $em->getRepository('EntityBundle:Category')->findAll();
        return $this->render('@Product/Category/listCategory.html.twig', array(
            "category" => $categorylist,
        ));
    }
    public function AddCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this -> createForm(CategoryType::class,$category);
        $form -> handleRequest($request);
        if ( $form -> isSubmitted() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute("list_category");
        }
        return $this->render('@Product/Category/add_category.html.twig', array("form"=>$form->createView()));

    }
    public function UpdateCategoryAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $category= $em->getRepository('EntityBundle:Category')->find($id);
        $form=$this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('info', 'Created Successfully !');
            return $this->redirectToRoute('list_category');
        }


        return $this->render('@Product/Category/update_category.html.twig', array("form"=>$form->createView()));
    }
    public function DeleteCategoryAction($id)
    {
        $category = $this -> getDoctrine() -> getRepository(Category::class) -> find($id);
        $em = $this -> getDoctrine() -> getManager();
        $em -> remove($category);
        $em -> flush();
        return $this -> redirectToRoute("list_category");
    }


}
