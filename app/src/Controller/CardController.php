<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\CardColor;
use App\Form\CardType;
use App\Form\CardColorType;
use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function card(Request $request) : Response
    {
        $card = new Card();

        $form = $this->createForm(CardType::class, $card);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($card);
            $entityManager->flush();

            return $this->redirectToRoute('show_card', ['id' => $card->getId()]);
        }

        return $this->renderForm('card/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/color")
     */
    public function index(Request $request): Response
    {
        $card_color = new CardColor();
        $form = $this->createForm(CardColorType::class, $card_color);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card_color = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($card_color);
            $entityManager->flush();

        }

        return $this->renderForm('card_color/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show_card")
     */
    public function cardShow(int $id, CardRepository $cardRepository) : Response
    {
       $card = $cardRepository->find($id);
       return $this->renderForm('card/show.html.twig', [
           'card' => $card,
       ]);
    }

}
