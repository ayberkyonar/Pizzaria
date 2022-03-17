<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PizzaController extends AbstractController
{
    /**
     * @Route("/home")
     */

    public function home(): Response
    {
        $categories = ["Vlees", "Vegetarisch", "Vis"];

        return $this->render('pizza/home.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/products/{category}")
     */
    public function products($category): Response
    {

        $pizzas = [
            "Vlees" => ['Salami', 'Hawaii'],
            "Vegetarisch" => ['Margarita', 'Fungi'],
            "Vis" => ['Tonno', 'Zeevruchten']
        ];

        return $this->render('pizza/products.html.twig', [
            'pizzas' => $pizzas[$category]
        ]);
    }
}