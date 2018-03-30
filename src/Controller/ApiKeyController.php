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

class ApiKeyController extends Controller
{
    /**
     * @Route("admin/apikeys", name="admin_apikeys")
     */
    public function apiKeysAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $api_keys = $em->getRepository('App:ApiKey')->findAll();
        return $this->render('apikey/apikeys.html.twig', array(
            'api_keys' => $api_keys,
        ));
    }

    /**
    * @Route("admin/apikey/{id}", name="admin_apikey")
    */
    public function apiKeyAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($id == '0'){
            $apikey = new ApiKey();
            $apikey->secret = $this->generateRandomString(30);
        } else {
            $apikey = $em->getRepository('App:ApiKey')->find($id);
        }

        $apikeyuses = $em->getRepository('App:ApiKeyUse')->getAllForKey($apikey);

        $form = $this->createForm(ApiKeyType::class, $apikey);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($apikey);
            $em->flush();
            return $this->redirectToRoute('admin_api_keys');
        }
        return $this->render('AppBundle:admin:apikey.html.twig', array(
            'form' => $form->createView(),
            'apikeyuses' => $apikeyuses,
        ));
    }

    /**
     * @Route("admin/apikeyuses", name="admin_api_key_uses")
     */
    public function apiKeyUsesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $apikey = $request->query->get('apikey');
        if($apikey){
            $apikeyuses = $em->getRepository('App:ApiKeyUse')->getAllForKey($apikey);
        } else {
            $apikeyuses = $em->getRepository('App:ApiKeyUse')->getAll();
        }

        return $this->render('AppBundle:admin:apikeyuses.html.twig', array(
            'apikeyuses' => $apikeyuses,
        ));
    }

    /**
     * @Route("admin/apikeyuse/{id}", name="admin_api_key_use")
     */
     public function apiKeyUseAction($id, Request $request)
     {
         $em = $this->getDoctrine()->getManager();
         if($id != '0'){
             $apikeyuse = $em->getRepository('App:ApiKeyUse')->find($id);
         }

         $form = $this->createForm(ApiKeyUseType::class, $apikeyuse);
         $form->handleRequest($request);

         return $this->render('AppBundle::base_form.html.twig', array(
             'form' => $form->createView()
         ));
     }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
