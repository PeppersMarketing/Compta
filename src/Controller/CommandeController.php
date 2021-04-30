<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\ProduitCommande;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\console;

class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    /**
     * @Route("/commande", name="commande")
     
     *  
     * @return void 
     */
    public function NewCommande(Commande $commande = null,Client $client = null, Produit $produit = null,
    ProduitCommande $produitCommande = null, Request $request)
    {
       
        $finder = new Finder;
        $finder->files()->in('xmls');
        $finder->files()->name('*.xml');
        //dump($finder);
        $form = $this->createForm(CommandeType::class, $commande  );
        $form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
            //if ($finder->hasResults()) {
                foreach (iterator_to_array($finder) as $file) {
                    /* @var $file \Symfony\Component\Finder\SplFileInfo */
                    $xmlObject  = simplexml_load_file($file);
                    $numClient = $xmlObject->Order->User['UserId'];
                    
                    $repoClient = $this->getDoctrine()->getRepository(Client::class);
                    $client = $repoClient->findBy(array('Numero' => $numClient));
                    dump($client);
                    $manager = $this->getDoctrine()->getManager();


                    if (!$commande) {
                        $commande = new Commande;
                    }


                    if (!$client) {
                        $client = new Client;
                        $email = strval($xmlObject->Order->User->Email);
                        $client->setEmail($email);
                        $numClient= intval($xmlObject->Order->User['UserId']);
                        $client->setNumero($numClient);
                        $client->setNom($xmlObject->Order->User->LastName);
                        $client->setPrenom($xmlObject->Order->User->FirstName);
                        $telephone= intval($xmlObject->Order->User->Phone);
                        $client->setTelephone($telephone);
                        $client->setSociete($xmlObject->Order->User->Company);
                        $manager->persist($client);
                        $manager->flush();
                        $commande->setClient($client);
                    }else{
                        $commande->setClient($client[0]);
                    }
                    
                    if (!$produitCommande) {
                        $produitCommande = new ProduitCommande;
                    }
                    

                    $numCommande = intval($xmlObject->Order['DisplayOrderId']);
                    $commande->setNumero($numCommande);
                   
                    $commande->setAdresseLivraison($xmlObject->Order->BillingAddress->Address1." ". $xmlObject->Order->BillingAddress->Address2 );
                    $commande->setVilleLivraison($xmlObject->Order->BillingAddress->City);
                    $commande->setCodePostalLivraison($xmlObject->Order->BillingAddress->ZipCode);
                    $Subtotal = intval($xmlObject->Order->Prices->Subtotal);
                    $commande->setTotalHT($Subtotal);
                    $Tax = intval($xmlObject->Order->Prices->Tax);
                    $commande->setTVA($Tax);
                    $TotalPrice = intval($xmlObject->Order->Prices->TotalPrice);
                    $commande->setTotalTTC($TotalPrice);
                    $shipping = intval($xmlObject->Order->Prices->ShippingPrice);
                    $mailingPrice = intval($xmlObject->Order->Prices->MailingPrice);
                    $totalShipping = $shipping + $mailingPrice;
                    $commande->setLivraison($totalShipping);
                    $date = substr($xmlObject->Order['CreationDate'], 0,-13);
                    $heure = substr($xmlObject->Order['CreationDate'], 11,-4);
                    $newDateTime = New \DateTime($date.' '.$heure);
                    $commande->setDate($newDateTime);
                    $manager->persist($commande);
                    $manager->flush();

                    foreach ($xmlObject->Order->OrderProducts->OrderProduct as $OrderProduct) {

                        $numProduit = intval($OrderProduct->Product['id']);
                        $repoProduit = $this->getDoctrine()->getRepository(Produit::class);
                        $produit = $repoProduit->findBy(array('Numero' => $numProduit));

                        if (!$produit) {
                            $produit = new Produit;
                            $produit->setNumero($numProduit);
                            $produit->setNom( $OrderProduct->Product->Name);
                            $CatalogNumber = intval($OrderProduct->Product->CatalogNumber);
                            $produit->setCategorie($CatalogNumber);
                            $produit->setManufactureur($OrderProduct->Product->Manufacturer->Name);
                            $manager->persist($produit);
                            $manager->flush();
                        }
                        
                       
                    }
                }
            //}

           
          //  return $this->redirectToRoute('commande');
        //}

        return $this->render('commande/affichage.html.twig', [
            'client' => $numClient,
            'form' => $form->createView()
        ]);
    }
    

}
