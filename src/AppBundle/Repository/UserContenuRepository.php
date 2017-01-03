<?php

namespace AppBundle\Repository;
use AppBundle\Entity\User;

/**
 * UserContenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserContenuRepository extends \Doctrine\ORM\EntityRepository
{
    // Les contenus aussi consultés sont classés par ceux qui ont le plus grand nombre de vue (et non de vue totale)
    public function findContenusFavoris(User $user)
    {
        $qb = $this->createQueryBuilder('uc');
        $qb->select(array("contenu.id", "contenu.titre", "contenu.information", "contenu.datePublication",
                         "contenu.nombreLike", "contenu.nombreVueTotal", "contenu.contenuRoot","contenu.imageRoot",
                         "rubrique.libelle as libelle_rubrique", "sousRubrique.libelle as libelle_sousRubrique", "uc.nbreVue"));
        $qb->join('uc.contenu', 'contenu');
        $qb->join('contenu.rubrique', 'rubrique');
        $qb->join('contenu.sousRubrique', 'sousRubrique');
        $qb->orderBy('uc.nbreVue','DESC');
        $qb->where('uc.user=:user');
        $qb->setParameter('user', $user);
        $qb->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }

    public function findConteneurs($criteres)
    {
        $qb = $this->createQueryBuilder('uc');;
        $qb->select("contenu.id", "contenu.titre", "contenu.information", "contenu.datePublication",
            "contenu.nombreLike", "contenu.nombreVueTotal", "contenu.contenuRoot","contenu.imageRoot",
            "rubrique.libelle as libelle_rubrique", "sousRubrique.libelle as libelle_sousRubrique",
            "groupeRubrique.libelle as libelle_groupeRubrique", "rubrique.imageRoot as imageRoot_rubrique","user.nom", "user.userProfilRoot", "user.id as user_id", "user.isPersonnel");
        $qb->join('uc.contenu', 'contenu');
        $qb->join('uc.user', 'user');
        $qb->join('contenu.rubrique', 'rubrique');
        $qb->leftJoin('rubrique.groupeRubrique', 'groupeRubrique');
        $qb->leftJoin('contenu.sousRubrique', 'sousRubrique');
        $qb->join('contenu.conteneurs', 'conteneurs');
        $qb->where('conteneurs.annee=:critereAnnee');
        $qb->andWhere('conteneurs.niveau=:critereNiveau');
        $qb->andWhere('conteneurs.groupe=:critereGroupe');
        $qb->andWhere('uc.aPublie = true');
        $qb->setParameter('critereAnnee', $criteres["annee"]);
        $qb->setParameter('critereNiveau', $criteres["niveau"]);
        $qb->setParameter('critereGroupe', $criteres["groupe"]);
        $qb->orderBy('contenu.datePublication' , "DESC");

        return $qb->getQuery()->getResult();
    }

//    public function findContenusFavorisWithEnseignant($contenuFavoriIDs)
//    {
//        $qb = $this->createQueryBuilder('uc');
//        $qb->select(array('uc', 'contenu', 'user.nom', 'user.prenom'));
//        $qb->join('uc.contenu', 'contenu');
//        $qb->join('uc.user', 'user');
//        $qb->orderBy('uc.nbreVue','DESC');
//        $qb->where('contenu.id IN (:contenuFavoriIDs)');
//        $qb->setParameter('contenuFavoriIDs', $contenuFavoriIDs);
//        return $qb->getQuery()->getResult();
//    }
}
