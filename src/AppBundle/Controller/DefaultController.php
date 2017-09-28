<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
   /**
    * @Route("/", name="homepage")
    */
   public function indexAction(Request $request)
   {
       // replace this example code with whatever you need
       return $this->render('default/index.html.twig', [
           'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
       ]);
   }
   /**
    * @Route("/lucky/number/{max}", name="lucky_number", defaults={"max":100}, requirements={"max":"\d*"})
   
    */
   public function numberAction($max)
   {
       // génération d'un nombre aléatoire
       
       $number = mt_rand(0, $max);
       //ici on va chercher le template et on lui transmet la variable
       return $this->render('AppBundle:Default:number.html.twig', array(
           // pour fournir des variables au template
           // a gauche, le nom qui sera utilisé dans le template
           // a droite, la valeur
           'number' => $number
       ));
   }
   
   
   /**
   *@Route("/blog/{title}/{year}",
   * name="autreblog",
    * defaults={"_locale":"fr"},
    * requirements={
    *    "year":"[0-9]{4}",
    *    "title":"[a-z]+"}
    *)
    * @Route("/blog/{_locale}/{title}/{year}",
    * name="blog",
    * defaults={"_locale":"fr"},
    * requirements={
    *    "_locale":"en|fr",
    *    "year":"\d{4}",
    *    "title":"[a-zA-Z0-9-]+"}
    *)

     */
    public function textAction($title, $year, $_locale)
    {  
       return $this->render('AppBundle:Default:blog.html.twig', array(
           'title' => $title,
           'year' => $year,
           '_locale' => $_locale,
       ));
    }
    // [...]
     /**
    * @Route("/layout", name="layout")
    */
   public function layout()
   {
       // replace this example code with whatever you need
       return $this->render('AppBundle::layout.html.twig', array(

       ));

       
   }
   
/**
* @Route("/db/", name="db")
*/
public function listArticleAction(){
   $em = $this->getDoctrine()->getManager();
   $articles = $em->getRepository(Article::class)->findAll();
   return $this->render('AppBundle:Default:article.html.twig', array(
   'articles'=> $articles
   ));
   
    }

    /**
* @Route("/db/{id}", name="db")
*/
public function showArticleAction($id){
    $em = $this->getDoctrine()->getManager();
    $articles = $em->getRepository(Article::class)->find($id);
    return $this->render('AppBundle:Default:articlebyid.html.twig', array(
    'articles'=> $articles
    ));
    }



/**
*@Route("/myentity/new", name="newentity")
*/

public function formAction(){
    $myArticle = new Article();
    $em = $this->getDoctrine()->getManager();
    
    $form = $this->createFormBuilder($myArticle)
    ->add('title', TextType::class)
    ->add('content', TextType::class)
    ->add('save', SubmitType::class, array('label' => 'Create Post'))

    ->getForm();

    return $this->render('AppBundle:Default:newentity.html.twig', array(
        'form' => $form->createView(),
    ));
    }
}