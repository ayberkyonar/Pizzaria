<?php
namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PizzaController extends AbstractController
{
    /**
     * @Route("/home")
     */

    public function home(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();
        //$categories = ["Vlees", "Vegetarisch", "Vis"];

        return $this->render('pizza/home.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/products/{id}")
     */
    public function products(Category $category, PizzaRepository $repository): Response
    {

        //$pizzas = [
        //    "Vlees" => ['Salami', 'Hawaii'],
        //    "Vegetarisch" => ['Margarita', 'Fungi'],
        //    "Vis" => ['Tonno', 'Zeevruchten']
        //];

        $pizzas = $repository->findBy(["cat" => $category]);
        return $this->render('pizza/products.html.twig', [
            "category" => $category,
            'pizzas' => $pizzas
        ]);
    }

    /**
     * @Route("/contact")
     */
    public function contact(): Response
    {

        return $this->render('pizza/contact.html.twig', [
        ]);
    }
}