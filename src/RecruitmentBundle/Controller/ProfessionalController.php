<?php

namespace RecruitmentBundle\Controller;

use EntityBundle\Entity\Professional;
use EntityBundle\Form\ProfessionalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfessionalController extends Controller
{
    public function ListProAction(){
        $em = $this->getDoctrine()->getManager();

        $prolist = $em->getRepository('EntityBundle:Professional')->findAll();
        return $this->render('@Recruitment/Professional/listProfessional.html.twig', array(
            "professional" => $prolist,
        ));
    }
    public function AddProAction(Request $request)
    {
        $pro = new Professional();
        $form = $this -> createForm(ProfessionalType::class,$pro);
        $form -> handleRequest($request);
        if ( $form -> isSubmitted() ) {
            $em = $this->getDoctrine()->getManager();
            $pro->uploadProfilePicture();
            $em->persist($pro);
            $em->flush();

            return $this->redirectToRoute("list_professional");
        }

        return $this->render('@Recruitment/Professional/add_pro.html.twig', array("form"=>$form->createView()
        ));
    }
    public function UpdateProAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $pro= $em->getRepository('EntityBundle:Professional')->find($id);
        $form=$this->createForm(ProfessionalType::class,$pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pro);
            $em->flush();
            $this->addFlash('info', 'Created Successfully !');
            return $this->redirectToRoute('list_professional');
        }


        return $this->render('@Recruitment/Professional/add_pro.html.twig', array("form"=>$form->createView()
        ));
    }
    public function DeleteProAction($id)
    {
        $pro = $this -> getDoctrine() -> getRepository(Professional::class) -> find($id);
        $em = $this -> getDoctrine() -> getManager();
        $em -> remove($pro);
        $em -> flush();
        return $this -> redirectToRoute("list_professional");
    }
}
