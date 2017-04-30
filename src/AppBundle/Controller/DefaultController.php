<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Entity\Tag;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine();
        $products = $em->getRepository('AppBundle:Product')->findAll();
        return $this->render('default/index.html.twig',['products'=>$products]);
    }

    /**
     * @Route("/form_product", name="form_product")
     */
    public function formProductAction(Request $request)
    {
        try {
            $product = new Product();
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $product->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('url_img_product'),
                    $fileName
                );
                $product->setImage($fileName);

                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                if(!empty($product->getFoodProduct())) {
                    $em->persist($product->getFoodProduct()->setProduct($product));
                }
                $em->flush();

                return new Response('Producto guardado correctamente',201);
            } else {
                return new Response($this->renderView('default/form_product.html.twig', ['form' => $form->createView()]),202);
            }
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @Route("/show_more", name="show_more")
     */
    public function showMoreAction(Request $request) {
        $id = $request->get('id');
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
        return $this->render('default/modal.information.html.twig', ['product' => $product]);
    }
}
