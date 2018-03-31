<?php

namespace App\Repository;

use App\Entity\ApiKeyUse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ApiKeyUse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiKeyUse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiKeyUse[]    findAll()
 * @method ApiKeyUse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiKeyUseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ApiKeyUse::class);
    }

    public function validate($key, $request){
        $secret = $request->query->get("security");
        $url = $request->getUri();

        $em = $this->getEntityManager();
        $apikey = $em->getRepository('App:ApiKey')->findOneById($key);

        $apikeyuse = new ApiKeyUse();
        $apikeyuse->datetime = new \Datetime();
        $apikeyuse->apikey = $apikey;
        $apikeyuse->url = $url;
        $apikeyuse->valid = false;
        $apikeyuse->my_log = "debut\n";
        $apikeyuse->my_log = $apikeyuse->my_log.json_encode($request->query->all())."\n";
        $apikeyuse->my_log = $apikeyuse->my_log."POST:\n".json_encode($request->request->all())."\n";
        $apikeyuse->my_error = "";
        if($apikey && $apikey->secret == $secret){
            $apikeyuse->valid = true;
        }
        $em->persist($apikeyuse);
        $em->flush();
        //print(json_encode($apikeyuse));
        return $apikeyuse;
    }

    public function getAll(){
        $query = $this->createQueryBuilder('p')
            ->addorderBy('p.datetime', 'DESC')
            ->setMaxResults(100)
            ->getQuery();

        return $query->getResult();
    }

    public function getAllForKey($key){
        $em = $this->getEntityManager();
        $apikey = $em->getRepository('App:ApiKey')->findOneById($key);

        $query = $this->createQueryBuilder('p')
            ->where("p.apikey = :apikey")
            ->addorderBy('p.datetime', 'DESC')
            ->setMaxResults(100)
            ->setParameter("apikey", $apikey)
            ->getQuery();

        return $query->getResult();
    }
}
