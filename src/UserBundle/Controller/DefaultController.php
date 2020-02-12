<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DefaultController extends Controller
{

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function indexAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if(!$user){
            return $this->render('UserBundle:Default:index.html.twig');
        }else{
            return $this->render('UserBundle:Default:index2.html.twig',array("user"=>$user));
        }

    }
}
