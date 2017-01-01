<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 27/11/2016
 * Time: 14:01
 */

namespace AppBundle\Entity;


class ContenusGroupes
{
    /**
     * @var Object
     */
    protected $favoris;
    protected $recents;
    protected $aussiconsultes;
    protected $conteneurs;

    /**
     * ContenusGroupes constructor.
     * @param $favoris
     * @param $recents
     * @param $aussiconsultes
     * @param $conteneurs
     */
    public function __construct($favoris, $recents, $aussiconsultes, $conteneurs)
    {
        $this->favoris = $favoris;
        $this->recents = $recents;
        $this->aussiconsultes = $aussiconsultes;
        $this->conteneurs = $conteneurs;
    }

    /**
     * @return mixed
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * @param mixed $favoris
     */
    public function setFavoris($favoris)
    {
        $this->favoris = $favoris;
    }

    /**
     * @return mixed
     */
    public function getRecents()
    {
        return $this->recents;
    }

    /**
     * @param mixed $recents
     */
    public function setRecents($recents)
    {
        $this->recents = $recents;
    }

    /**
     * @return mixed
     */
    public function getAussiconsultes()
    {
        return $this->aussiconsultes;
    }

    /**
     * @param mixed $aussiconsultes
     */
    public function setAussiconsultes($aussiconsultes)
    {
        $this->aussiconsultes = $aussiconsultes;
    }

    /**
     * @return mixed
     */
    public function getConteneurs()
    {
        return $this->conteneurs;
    }

    /**
     * @param mixed $conteneurs
     */
    public function setConteneurs($conteneurs)
    {
        $this->conteneurs = $conteneurs;
    }



}