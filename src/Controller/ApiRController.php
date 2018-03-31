<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ApiRController extends Controller
{
    /**
     * @Route("api", name="admin_r")
     */
    public function apiRAction(Request $request)
    {
        $path = 'Rscript --vanilla '.dirname(__DIR__)."/../r/sample.R";
        $process = new Process($path);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $path;
        echo $process->getOutput();
        return new JsonResponse();
    }

    /**
     * @Route("api/sample_r", name="admin_r")
     */
    public function apiSampleAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $apikeyuse = $em->getRepository('App:ApiKeyUse')->validate("sample_r", $request);
        if(!$apikeyuse->valid){
            return new Response("not authorized", 401);
        }

        $res = ["c'est bien", "ok"];


        return new JsonResponse($res);
    }
}
