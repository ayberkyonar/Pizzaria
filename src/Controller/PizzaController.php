<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Pizza;
use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->render('pizza/home.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/products/{id}")
     */
    public function products(Category $category, PizzaRepository $repository): Response
    {
        $pizzas = $repository->findBy(["cat" => $category]);

        return $this->render('pizza/products.html.twig', [
            "category" => $category,
            'pizzas' => $pizzas
        ]);
    }

 /**
     * @Route("/orderpizza/{id}", name="app_order_pizza")
     */
    public function new(Pizza $pizza, Request $request, OrderRepository $orderRepository): Response
    {

        // creates a task object and initializes some data for this example
        $order = new Order();
        $order->setPizza($pizza);
        $order->setStatus("ordered");

        $form = $this->createFormBuilder($order)
            ->add('fname')
            ->add('lname')
            ->add('address')
            ->add('city')
            ->add('zipcode')
            ->add('size')
            ->add('submit', SubmitType::class, ['label' => 'Order Pizza'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $order = $form->getData();

            // ... perform some action, such as saving the order to the database
            $orderRepository->add($order);
            return $this->redirectToRoute('task_success');
        }

        return $this->renderForm('pizza/order.html.twig', [
            'form' => $form,
            'pizza' =>$pizza
        ]);

    }

    /**
     * @Route("/order/succes", name="task_success")
     */
    public function succes():Response{
        return $this->render('pizza/task_success.html.twig');
    }

}
