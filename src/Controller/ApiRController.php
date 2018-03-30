<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use App\Form\UserType;
use App\Form\ApiKeyType;
use App\Form\ApiKeyUseType;
use App\Form\OauthClientType;

use App\Entity\OauthClient;
use App\Entity\OAuthClientDescription;
use App\Entity\ApiKey;

class ApiRController extends Controller
{
    /**
     * @Route("api", name="admin_r")
     */
    public function apiRAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $api_keys = $em->getRepository('App:ApiKey')->findAll();
        return $this->render('apikey/apikeys.html.twig', array(
            'api_keys' => $api_keys,
        ));
    }
}
