<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/02/2017
 * Time: 21:37
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Inutile;
use AppBundle\Form\Type\InutileType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InutileController extends Controller
{

    /**
     * @Rest\View(serializerGroups={"question"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/inutile")
     */
    public function postInutileAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $ref = $request->get('ref');
        $refID = $request->get('refID');
        $userID = $request->get('userID');
        $inutile= $em->getRepository('AppBundle:Inutile')->findOneBy(array("ref"=>$ref, "refID"=>$refID, "userID"=>$userID));

        $refEntity = $em->getRepository('AppBundle:'.$ref)->find($refID);

        $nbreInutile= $refEntity->getNbreInutile();

        if(!empty($inutile))
        {
            $em->remove($inutile);
            $refEntity->setNbreInutile($nbreInutile-1);

            $em->persist($refEntity);
            $em->flush();
            return $refEntity;

        }else{
            $inutile = new Inutile();
            $inutile->setRef($ref)
                ->setUserID($userID)
                ->setRefID($refID);

            $form = $this->createForm(InutileType::class, $inutile);

            $form->submit($request->request->all());

            $refEntity->setNbreInutile($nbreInutile+1);

            if ($form->isValid()) {

                $em->persist($refEntity);
                $em->persist($inutile);
                $em->flush();
                return $refEntity;

            } else {
                return $form;
            }
        }
    }


}