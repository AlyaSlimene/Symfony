<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="ListProd")
     */
    public function index(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Product::class);
        $products=$repo->findAll();
        #$products=["article1","article2","article2"];
        # $products=[1, {"libel": "article1","prix":"12","description":""}]
        return $this->render('product/index.html.twig', ['products' => $products]);
    }

    public function cartitem(): Response
    {
            return $this->render('product/index.html.twig', ['products' => $products]);
    }

    /**
     *  @Route("/product/detail/{id}", name="detaiProd")
     * 
     */
    public function detail($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $product=$repo->find($id);
        return $this->render('product/detail.html.twig', ['product' => $product]);
    }

    /**
     *  @Route("/product/add", name="addProd")
     * 
     */
    public function add(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setLibelle("lib test2")
                ->setPrix(4112)
                ->setDescription("description de article test2")
                ->setImage("http://placehold.it/350*150");
        $manager->persist($product);  
        $manager->flush();

        
        return new Response('Saved new product with id '.$product->getId());  
        #return $this->redirectToRoute('ListProd');
    }
    /**
     * @Route("/product/{id}/edit","modif")
     * @Route("/product/add2","add2")
     */
    
    public function form(Product $prod=null,Request $request)
        {
            if (! $prod)
            {
                $prod = new Product();
            }
            $manager=$this->getDoctrine()->getManager();
            //$prod = new Product();
            
            $form = $this->createForm(ProductType::class, $prod);
           
            $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            //$task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
             $manager->persist($prod);
             $manager->flush();

            return $this->redirectToRoute('ListProd');
        }
            return $this->renderForm('product/edit.html.twig', [
                'form' => $form,
            ]);
        }        
    

    /**
     *  @Route("/product/delete/{id}", name="delProd")
     * 
     */
    public function delete($id): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $product=$repo->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'Aucun produit avec id '.$id
            );
        }
        $manager->remove($product);
        $manager->flush();
          
     
        #return new Response('Suppression validée du produit ');    }
        return $this->redirectToRoute('ListProd');
    }
}
