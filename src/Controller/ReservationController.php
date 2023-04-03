<?php

namespace App\Controller;
use App\Entity\Reservation;
use App\Entity\Terrain;
use App\Entity\Utilisateur;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\ReservationRepository;
use App\Service\MailerService;
use Symfony\Component\Mime\Email;


#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/newFront', name: 'app_reservation_newfront', methods: ['GET', 'POST'])]
    public function newFront(Request $request, EntityManagerInterface $entityManager,MailerService $mailer): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $id_user= $reservation->getIdUtilisateur();
            $client = $entityManager->getRepository(Utilisateur::class)->find($id_user);
            $to=$client->getMail();
            $mailer->sendEmail($to);
            $entityManager->flush();

            return $this->redirectToRoute('app_terrain_front', [], Response::HTTP_SEE_OTHER);
        }
      
        return $this->renderForm('reservation/newFront.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }


    
    /*#[Route ('ComfirmationReservation{id}',name:'ComfirmationReservation')]
    public function ComfirmationReservation($id, \Swift_Mailer $mailer)
    {
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->findOneBy(['idreser' => $idReservation]);
        $idu = $reservation->getIdUtilisateur();
        $idt = $reservation->getIdTerrain();
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['id' => $idUtilisateuru]);
        $mail = $utilisateur->getMail();
        $nom = $utilisateur->getNom();
        $terrain = $this->getDoctrine()->getRepository(Terrain::class)->findOneBy(['idT' => $idTerrain]);
        $nomT = $terrain->getNomTerrain();



        $message = (new \Swift_Message('Confirmation Email'))
            ->setFrom('PLAYZONE@gmail.com')
            ->setTo('islem.amor@esprit.tn')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'email/contact.html.twig',
                    ['nom' => $nom,
                        'titre' => $titre
                        
                        
                    ]
                ),
                'text/html'

            );

        $mailer->send($message);

        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository(Reservation::class)->find($idReservation);
        $em = $this->getDoctrine()->getManager();
        $em->persist($e);
        $em->flush();

        return $this->redirectToRoute('MesReservation');


    }
*/    

    #[Route('/{idReservation}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{idReservation}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{idReservation}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdReservation(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

   
   
   
       
}