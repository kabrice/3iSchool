<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/11/2016
 * Time: 10:52
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Conteneur;
use AppBundle\Entity\Contenu;
use AppBundle\Entity\ContenusGroupes;
use AppBundle\Entity\Rubrique;
use AppBundle\Entity\UserContenu;
use AppBundle\Form\Type\UserType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;

class UserController extends Controller
{

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users/{id}")
     */
    public function getEtudiantAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('AppBundle:User')->findUserOnlyWithCredentials($request->get('id'));

        if (empty($user)) {
            return new JsonResponse(['message' => 'Utilisateur introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $user;

    }

    /**
     * @Rest\View(serializerGroups={"conteneur", "rubrique", "contenu", "user", "typeQuestion", "reponse"})
     * @Rest\Get("/users/{user_id}/{annee_id}/{groupe_id}/{niveau_id}")
     */
    public function getConteneurAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $annee = $em->getRepository("AppBundle:Annee")->find($request->get('annee_id'));
        $groupe = $em->getRepository("AppBundle:Groupe")->find($request->get('groupe_id'));
        $niveau = $em->getRepository("AppBundle:Niveau")->find($request->get('niveau_id'));
        $user = $em->getRepository("AppBundle:User")->find($request->get('user_id'));



        if (empty($annee) || empty($groupe) | empty($niveau)) {
            return new JsonResponse(['message' => 'Conteneur introuvable'], Response::HTTP_NOT_FOUND);
        }


       $contenusIDFavorisFromUserContenus= $em->getRepository("AppBundle:UserContenu")
                            ->findContenusIDFavoris($user);
        $contenuIDFavoris =[];
        foreach ($contenusIDFavorisFromUserContenus as $contenusIDFavorisFromUserContenu)
        {
            $contenuIDFavoris[]=$contenusIDFavorisFromUserContenu["id"];
        }
       $contenuFavoris = $em->getRepository("AppBundle:Contenu")->findById($contenuIDFavoris);
       $contenuRecents = $em->getRepository("AppBundle:Contenu")->findContenusRecents();
       $contenuAussiConsultes = $em->getRepository('AppBundle:Conteneur')
            ->findContenusAussiConsultes(array('annee'=>$annee,
                           'groupe'=>$groupe,
                           'niveau'=>$niveau));
        $tousLesContenusPromotion = $em->getRepository('AppBundle:Conteneur')
            ->findBy(array('annee'=>$annee,
                'groupe'=>$groupe,
                'niveau'=>$niveau));;

        //return array("FAVORIS"=>$contenuFavoris);

        // BOUCLE POUR MAJ LE TOTAL NBRE VU

//        $arrayDescription= array("<p class='qtext_para'>This is an excellent discovery! Congratulations!</p><p class='qtext_para'>My father (a now retired electrical engineering professor) once told me something wise about this decades ago. I'd been complaining about my struggles in graduate school. I was about your age. I whined, 'The more I learn the more stupid I feel!'</p><p class='qtext_para'>'Good!' he declared. 'That means you're getting smart!'</p><p class='qtext_para'><i>UPDATE: This answer has gotten more up votes than any other I've given on Quora since I joined a few years ago. I have no idea why. Anyone care to venture a guess? Thanks everyone! ~ jdk</i><br>2nd UPDATE: Found this quote today, 4/7/15: <i>'In seeking wisdom thou are wise; in imagining that thou has attained it, thou are a fool.' ~ </i>Rabbi Ben-Azzal</p><p class='qtext_para'>3rd UPDATE: More backup from <span class='qlink_container'><a href='http://www.nobelprize.org/nobel_prizes/literature/laureates/1950/russell-bio.html' rel='noopener nofollow' target='_blank' onclick='return Q.openUrl(this);' class='external_link tooltip_parent' data-qt-tooltip='nobelprize.org' data-tooltip='attached'>Bertrand Russell</a></span>: “The whole problem with the world is that fools and fanatics are always so certain of themselves, and wise people are full of doubts.”</p>",
//                                 "<p class='qtext_para'>Jon - most religious people would disagree that the divine has given “no clear indication” of its intentions. Of course, you are free to disagree with this. Yet your claim that this is “certainly” the case seems to me to be unsubstantiated. For millennia, the world’s major religious traditions have been in fundamental agreement on the core tenets of human behavior. They may differ in orthodoxy, but their claims about [ortho]praxis are strikingly similar.</p><p class='qtext_para'>Perhaps your Rule #5 is meant to address this. Yet economics, political science and psychology all tell us that millions of people act differently than pure reason would indicate. This has little to do with religion - it’s simply a fact of human existence. I’m happy to provide the examples from each discipline, if you like.</p><p class='qtext_para'>Cheers, -GJ</p>",
//                                 "<span class='rendered_qtext'>Read, read, read. <br><br>Listen, listen, listen. <br><br>Do stuff, observe, learn. Don't defend mistakes or failures. Learn from them. Failure is an incredibly efficient teacher, if you're willing to take the lessons on board.</span>",
//                                 "<p class='qtext_para'>Subscibe to philosophy youtube channels, read books, watch good movies and art so you can intepret them.</p><p class='qtext_para'><b>But most important, become analytical.</b></p><p class='qtext_para'>Analyze your daily conversations and reactions with people,</p><p class='qtext_para'>¨Why did I say that¨</p><p class='qtext_para'>¨why did I do that¨</p><p class='qtext_para'>¨What are their motivations behind that action¨</p><p class='qtext_para'><b>At least this has worked for me.</b></p>");
//        $arrayLibelle= array("JSON.stringify() fails when converting a large JavaScript object to a JSON string in IE 11+ ?",
//                               "How to add page number in laravel dompdf?",
//                               "What is the convention to handle secondary action of UIButton in iOS",
//                               "How to get Webpack, Wordpress, and BrowserSync to work together?");
//        $arrayImage = array("img/imagesQuestions/dog_resting.png",
//                            "img/imagesQuestions/groom_dress.jpeg",
//                            "img/imagesQuestions/linux_beard.jpeg",
//                            "img/imagesQuestions/man_pulling_door.png",
//                            "img/imagesQuestions/weird_washing_machine.jpeg");
//
//            $questions = $em->getRepository("AppBundle:Question")->findAll();
//            $n=0;
//            foreach($questions as $comment)
//            {
//                    $i = rand(0, 4);
//                $comment->setLibelle($arrayPresentation[$n]);
//                $n++;
//                $em->merge($comment);
//                $em->flush();
//
//            }






        $contenusGroupes = new ContenusGroupes($contenuFavoris, $contenuRecents, $contenuAussiConsultes, $tousLesContenusPromotion);

        return array("FAVORIS"=>$contenuFavoris, "RECENTS"=>$contenuRecents,
                    "AUSSICONSULTES"=>$contenuAussiConsultes, "CONTENEUR"=>$tousLesContenusPromotion);

    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Patch("/users/{id}")
     */
    public function patchUserAction(Request $request)
    {
        return $this->updateUser($request, false);
    }

    private function updateUser(Request $request, $clearMissing)
    {
        $user = $this->getDoctrine()->getEntityManager()
            ->getRepository('AppBundle:User')
            ->find($request->get('id'));

        if (empty($user)) {
            return $this->userNotFound();
        }

        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }

        $form = $this->createForm(UserType::class, $user, $options);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            // Si l'utilisateur veut changer son mot de passe
            if (!empty($user->getPlainPassword())) {
                $encoder = $this->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
            }
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    private function userNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Utilisateur introuvable'], Response::HTTP_NOT_FOUND);
    }

}