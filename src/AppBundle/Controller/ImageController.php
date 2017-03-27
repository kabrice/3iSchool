<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/02/2017
 * Time: 17:20
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Image;
use AppBundle\Form\Type\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{

    /**
     * @Rest\View(serializerGroups={"image"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/images")
     */
    public function postImageAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();

        $image = new Image();

        $form = $this->createForm(ImageType::class, $image);
        $form->submit($request->request->all());



        if ($form->isValid()) {

            $data = $request->get('imgB64');
            $file_name = md5(uniqid(rand(), true)).$request->get('name');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            $type = finfo_buffer(finfo_open(), $data, FILEINFO_MIME_TYPE);

            // Todo à changer une fois hébergée sur le site
            file_put_contents("img/imgUpload/".$file_name, $data);
            $image->setImageRoot("http://www.3ilcours.fr/img/imgUpload/".$file_name);
            $em->persist($image);
            $em->flush();
            return $image;

        } else {
            return $form;
        }
        //echo var_dump($_FILES);
       /* $filename = $_FILES['file']['name'];
        $meta = $_POST;
        $destination = $meta['targetPath'] . $filename;
        move_uploaded_file( $_FILES['file']['tmp_name'] , $destination );*/


    }

}