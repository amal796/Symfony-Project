<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\TerrainRepository;
use Knp\Snappy\Pdf;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\PdfGeneratorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;


#[Route('/terrain')]
class TerrainController extends AbstractController
{
    #[Route('/', name: 'app_terrain_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $terrains = $entityManager
            ->getRepository(Terrain::class)
            ->findAll();

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }
    #[Route('/front', name: 'app_terrain_front', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $terrains = $entityManager
            ->getRepository(Terrain::class)
            ->findAll();

        return $this->render('terrain/showFront.html.twig', [
            'terrains' => $terrains,
        ]);
    }
 
    #[Route('/new', name: 'app_terrain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $terrain->getImageTerrain();
                $filename = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('uploads'),$filename);
                $terrain->setImageTerrain($filename);
            $entityManager->persist($terrain);
            $entityManager->flush();

            return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('terrain/new.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }

    #[Route('/order_By_Nom', name:'order_By_Nom' ,methods:['GET'])]
    public function order_By_Nom(Request $request,TerrainRepository $TerrainRepository): Response
    {

        $TerrainByNom = $TerrainRepository->order_By_Nom();

        return $this->render('terrain/showFront.html.twig', [
            'terrains' => $TerrainByNom,
        ]);

        //trie selon Date normal

    }
    
    #[Route('/order_By_Description', name:'order_By_Description' ,methods:['GET'])]
    
    public function order_By_Description(Request $request,TerrainRepository $TerrainRepository): Response
    {
        $TerrainByDescription = $TerrainRepository->order_By_Description();

        return $this->render('terrain/showFront.html.twig', [
            'terrains' => $TerrainByDescription,
        ]);

       

    }
    
    #[Route('/recherche', name:'terrain_recherche')]
    public function recherche(Request $request, TerrainRepository $repository)
    {
        $data= $request->get('search');
        $terrain=$repository->findBy(['nomTerrain'=>$data]);


        return $this->render('terrain/search.html.twig', [
            'terrains'=>$terrain]);

    }
///////////////////////////////////////////////////////////////////
     


    #[Route('/afficheJson', name: 'afficheJson')]
    public function show_mobile(TerrainRepository $TerrainRepository,NormalizerInterface $normalizer): Response
    {
        $Terrain=$TerrainRepository->findAll();
        $jsonContent = $normalizer->normalize($Terrain, 'json', ['groups' => 'post:read']);
        dump( $jsonContent);
        return new Response(json_encode($jsonContent));
       
    }


  
    ////////////////////////////////////////////////////////////
    #[Route('/AddjsonM', name: 'app_addjsonM')]
public function addjson(Request $request)
{
    $terrain = new Terrain();
    $nomTerrain = $request->query->get("nomTerrain");
    $descriptionTerrain = $request->query->get("descriptionTerrain");
    $surfaceTerrain = $request->query->get("surfaceTerrain");
    $lieu = $request->query->get("lieu");
    $imageTerrain = $request->query->get("imageTerrain");
    
    $terrain->setNomTerrain($nomTerrain);
    $terrain->setDescriptionTerrain($descriptionTerrain);
    $terrain->setSurfaceTerrain($surfaceTerrain);
    $terrain->setLieu($lieu);
    $terrain->setImageTerrain($imageTerrain);
    
    $em = $this->getDoctrine()->getManager();

    $em->persist($terrain);
    $em->flush();

    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize($terrain);
    return new JsonResponse($formatted);
}
////////////////////////////////////////////////////////////////////////////
    #[Route("/modifierM/{id}", name:"modifM")]
        
    public function updateMaisonMobile(Request $req,$id, NormalizerInterface $Normalizer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $terrain = $em->getRepository(Terrain::class)->find($id);

        $terrain->setNomTerrain($req->get('nomTerrain'));
        $terrain->setDescriptionTerrain($req->get('descriptionTerrain'));
        $terrain->setSurfaceTerrain($req->get('surfaceTerrain'));
        $terrain->setLieu($req->get('lieu'));
        $terrain->setImageTerrain($req->get('imageTerrain'));

        

        $em->flush();

        $jsonContent = $Normalizer->normalize($terrain, 'json', ['groups' => 'terrains']);
        return new Response('La terrain a été modifiée avec succès : '. json_encode($jsonContent));
    }

    
    /////////////////////////////////////////////////////////////
   
    
   


    #[Route('/{idTerrain}', name: 'app_terrain_show', methods: ['GET'])]
    public function show(Terrain $terrain): Response
    {
        return $this->render('terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }

    #[Route('/{idTerrain}/show', name: 'app_terrain_frontShow', methods: ['GET','POST'])]
    public function showF(Terrain $terrain): Response
    {
        return $this->render('terrain/showF.html.twig', [
            'terrain' => $terrain,
        ]);
    }


    #[Route('/{idTerrain}/edit', name: 'app_terrain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $terrain->getImageTerrain();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'),$filename);
            $terrain->setImageTerrain($filename);
            $entityManager->flush();

            return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('terrain/edit.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }
    

    #[Route('/{idTerrain}', name: 'app_terrain_delete', methods: ['POST'])]
    public function delete(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$terrain->getIdTerrain(), $request->request->get('_token'))) {
            $entityManager->remove($terrain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/show_in_map/{idTerrain}', name: 'app_terrain_map', methods: ['GET'])]
    public function Map( Terrain $idTerrain,EntityManagerInterface $entityManager ): Response
    {

        $terrain = $entityManager
            ->getRepository(Terrain::class)->findBy( 
                ['idTerrain'=>$idTerrain ]
            );
        return $this->render('terrain/api_arcgis.html.twig', [
            'terrains' => $terrain,
        ]);

    }
    
    #[Route('/pdf/terrain', name: 'generator_service')]
    public function pdfService(): Response
    { 
        $terrain= $this->getDoctrine()
        ->getRepository(Terrain::class)
        ->findAll();

   

        $html =$this->renderView('pdf/indexTerrain.html.twig', ['terrains' => $terrain]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
       
    }
//////////////////////////////////////////////////////////////////////////////////////
    #[Route("/deleteM/{id}", name:"supprimeM")]
        
        
    public function delete_mobile(Request $request,$id, NormalizerInterface $Normalizer): Response
        {   
           
        $em = $this->getDoctrine()->getManager();
        $terrain = $em->getRepository(Terrain::class)->find($id);
        
    
            $em->remove($terrain);
            $em->flush();
            $jsonContent = $Normalizer->normalize($terrain , 'json',['groups' => 'terrains']);
            return new Response("terrain deleted successfully" . json_encode($jsonContent));

      
        }
//////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('/afficheJson/{id}', name: 'afficheJsonid')]
    public function show_mobileD($id,TerrainRepository $TerrainRepository,NormalizerInterface $normalizer): Response
    {
        $Terrain=$TerrainRepository->find($id);
        $TerrainNormalises = $normalizer->normalize($Terrain, 'json', ['groups' => 'terrains']);
        return new Response(json_encode($TerrainNormalises));
    
    }
}
