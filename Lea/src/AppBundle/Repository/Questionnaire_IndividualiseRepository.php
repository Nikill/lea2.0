<?php

namespace AppBundle\Repository;

/**
 * Questionnaire_IndividualiseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Questionnaire_IndividualiseRepository extends \Doctrine\ORM\EntityRepository
{
    public function findQuestionnairesAcompleter($user){
        $qb= $this->createQueryBuilder('q');
        $qb->innerJoin('AppBundle:Questionnaire', 'q2', 'WITH', 'q2.id=q.questionnaire');
        $qb ->where("q.signatureEtudiant=false and q2.dateOuverture < :date");
        $qb->setParameter("date", new \DateTime());

        return $qb
            ->getQuery()
            ->getResult();
    }
}
