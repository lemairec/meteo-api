<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiKeyUse
 *
 * @ORM\Table(name="api_key_use")
 * @ORM\Entity(repositoryClass="App\Repository\ApiKeyUseRepository")
 */
class ApiKeyUse
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="ApiKey")
     * @ORM\JoinColumn(name="apikey_id", referencedColumnName="id", nullable=true)
     */
    public $apikey;

    /**
     * @var \Bool
     *
     * @ORM\Column(type="boolean")
     */
    public $valid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Datetime", type="datetime")
     */
    public $datetime;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    public $url;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    public $my_error;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    public $my_log;

    public function getDatetimeStr(){
        return $this->datetime->format("Y-m-d\TH:i:s");
    }

    public function log($str){
        $this->my_log = $this->my_log.$str."\n";
    }
}
