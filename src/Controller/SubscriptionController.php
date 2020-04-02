<?php

namespace App\Controller;

use App\Controller\Traits\SaveSubscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Subscription;

class SubscriptionController extends AbstractController
{
    use SaveSubscription;
    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing()
    {
        return $this->render('front/pricing.html.twig', [
            'name' => Subscription::getPlanDataNames(),
            'price' => Subscription::getPlanDataPrices(),

        ]);
    }


//    /**
//     * @Route("/payment" , name="payment")
//     */
//    public function payment()
//    {
//        return $this->render('front/payment.html.twig');
//    }


    /**
     * @Route("/payment/{paypal}" , name="payment", defaults = {"paypal": false})
     */
    public function payment($paypal, SessionInterface $session)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        if($paypal)
        {
            $this->saveSubscription($session->get('planName'),$this->getUser());
            return $this->redirectToRoute('admin_main');
        }
        return $this->render('front/payment.html.twig');
    }



}
