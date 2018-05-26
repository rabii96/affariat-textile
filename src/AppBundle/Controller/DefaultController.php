<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Archive;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Produit;
use AppBundle\Form\ProduitType;
use AppBundle\Entity\Annonceur;
use AppBundle\Form\AnnonceurType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class DefaultController extends Controller
{


    /**
     * @Route("/produits", name="produits")
     */
    public function produitsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $motCle = $request->get('motCle');
        $region = $request->get('region');
        if($region!=''){
            $ville = $request->get('ville');
        }else{
            $ville = '';
        }
        $categorie = $request->get('categorie');
        $tri = $request->get('tri');
        $type = $request->get('type');
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        if ($type==null){
            $type = 'Offre';
        }
        $paginator = $this->get('knp_paginator');
        if ($tri == 'prix') {
            $query = $em->createQuery(
                'SELECT p from AppBundle:Produit p
                ORDER BY p.prix ASC'
            );
            $produits = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 9)
            );
        } else {

            $query = $em->createQuery(
                'SELECT p from AppBundle:Produit p
                ORDER BY p.dateAjout DESC'
            );
            $produits = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 9)
            );
        }
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findBy(
            [],
            ['id' => 'DESC']
        );
        $regions = $this->getDoctrine()->getRepository('AppBundle:Region')->findAll();
        $villes = $this->getDoctrine()->getRepository('AppBundle:Ville')->findAll();
        $results = 'Toutes les annonces';
        return $this->render('Textiles/produits.html.twig', array(
            'produits' => $produits,
            'categories' => $categories,
            'regions' => $regions,
            'villes' => $villes,
            'results' => $results,
            'choixCateg' => $categorie,
            'choixRegion' => $region,
            'choixVille' => $ville,
            'motCle' => $motCle,
            'tri' => $tri,
            'type' => $type,
            'horizentale' => $horizentale,
            'verticale' => $verticale
        ));
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homeAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findBy(
            [],
            ['id' => 'DESC']
        );        
        $regions = $this->getDoctrine()->getRepository('AppBundle:Region')->findAll();
        $villes = $this->getDoctrine()->getRepository('AppBundle:Ville')->findAll();
        $motCle = $request->get('motCle');
        $categorie = $request->get('categorie');
        $region = $request->get('region');
        if($region!=''){
            $ville = $request->get('ville');
        }else{
            $ville = '';
        }
        $tri = $request->get('tri');
        $type = $request->get('type');
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        if($type==null){
            $type = 'Offre';
        }
        return $this->render('Textiles/home.html.twig', array(
            'categories' => $categories,
            'regions' => $regions,
            'villes' => $villes,
            'choixCateg' => $categorie,
            'choixRegion' => $region,
            'choixVille' => $ville,
            'motCle' => $motCle,
            'tri' => $tri,
            'type' => $type,
            'horizentale' => $horizentale,
            'verticale' => $verticale
        ));
    }

    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouterAction(Request $request)
    {
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $sousCategories = $this->getDoctrine()->getRepository('AppBundle:SousCategorie')->findAll();
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findAll();
        $regions = $this->getDoctrine()->getRepository('AppBundle:Region')->findAll();
        $villes = $this->getDoctrine()->getRepository('AppBundle:Ville')->findAll();

        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nomprod = $form['nomprod']->getData();
            $prix = $form['prix']->getData();
            $description = $form['description']->getData();
            $categorie = $form['categorie']->getData();
            $image = $form['image']->getData();
            $region = $form['region']->getData();
            $sousCategorie = $request->get('sousCategorie');
            $ville = $request->get('ville');
            $annonceur = $this->getUser();
            $afficherNum = $request->get('afficherNum');
            if($afficherNum=='true'){
                $afficherNum = 1;
            }else{
                $afficherNum = 0;
            }

            /**
             * @var UploadedFile $file
             */
            $file = $produit->getImage();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'), $filename
            );

            $now = new\DateTime('now');


            $produit->setNomProd($nomprod);
            $produit->setPrix($prix);
            $produit->setDescription($description);
            $produit->setCategorie($categorie);
            $produit->setImage($filename);
            $produit->setRegion($region);
            $produit->setIdAnnonceur($annonceur);
            $produit->setDateAjout($now);
            $sousCategorie = $this->getDoctrine()->getRepository('AppBundle:SousCategorie')->findOneBy(['id' => $sousCategorie]);
            $ville = $this->getDoctrine()->getRepository('AppBundle:Ville')->findOneBy(['id' => $ville]);
            $produit->setSousCategorie($sousCategorie);
            $produit->setVille($ville);
            $produit->setAfficherNum($afficherNum);


            $em = $this->getDoctrine()->getManager();

            $em->persist($produit);
            $em->flush();

            $this->addFlash(
                'notice',
                'Produit ajouté avec succés'
            );

            return $this->redirectToRoute('produits');

        }

        return $this->render('Textiles/ajouter.html.twig', array(
            'form' => $form->createView(),
            'verticale' => $verticale,
            'horizentale' => $horizentale,
            'sousCategories' => $sousCategories,
            'categories' => $categories,
            'regions' => $regions,
            'villes' => $villes
        ));
    }

    /**
     * @Route("/produit/{id}",defaults={"id" = 1}, name="produit")
     */
    public function produitAction($id)
    {
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $produit = $this->getDoctrine()
        ->getRepository('AppBundle:Produit')
        ->find($id);
        if ($produit) {
            return $this->render('Textiles/produit.html.twig', array(
                'produit' => $produit,
                'horizentale' => $horizentale,
                'verticale' => $verticale
            ));
        } else {
            $this->addFlash(
                'error',
                'Produit Introuvable'
            );
            return $this->redirectToRoute('produits');
        }

    }

    /**
     * @Route("/produits/{categ}", name="produits_categ")
     */
    public function produitsCategAction($categ, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findBy(
            [],
            ['id' => 'DESC']
        );        
        $regions = $this->getDoctrine()->getRepository('AppBundle:Region')->findAll();
        $villes = $this->getDoctrine()->getRepository('AppBundle:Ville')->findAll();
        $categ = ucwords($categ);
        $motCle = $request->get('motCle');
        $categorie = $request->get('categorie');
        $tri = $request->get('triCateg');
        $region = $request->get('region');
        if($region!=''){
            $ville = $request->get('ville');
        }else{
            $ville = '';
        }
        $type = $request->get('type');
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        if($type==null){
            $type = 'Offre';
        }
        $paginator = $this->get('knp_paginator');

        $c = $this->getDoctrine()
        ->getRepository('AppBundle:Categorie')
        ->findOneBy([
            'nomCategorie' => $categ
        ]);

        if ($tri == 'prix') {
            $query = $em->createQuery(
                'SELECT p from AppBundle:Produit p 
                JOIN p.categorie c
                WHERE c.nomCategorie like :c
                ORDER BY p.prix ASC')
            ->setParameter('c', '%' . $c->getNomCategorie() . '%');
            $produits = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 9)
            );
        } else {
            $query = $em->createQuery(
                'SELECT p from AppBundle:Produit p 
                JOIN p.categorie c
                WHERE c.nomCategorie like :c
                ORDER BY p.dateAjout DESC')
            ->setParameter('c', '%' . $c->getNomCategorie() . '%');
            $produits = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 9)
            );
        }
        $results = 'Annonces trouvés dans la catégorie ' . ucwords($categ);
        if ($produits->getTotalItemCount() == 0) {
            $results = 'Aucune annonce trouvée dans la catégorie ' .ucwords($categ);
        }
        return $this->render('Textiles/produits_categ.html.twig', array(
            'produits' => $produits,
            'categ' => $categ,
            'categories' => $categories,
            'regions' => $regions,
            'villes' => $villes,
            'results' => $results,
            'choixCateg' => $categorie,
            'choixRegion' => $region,
            'choixVille' => $ville,
            'motCle' => $motCle,
            'tri' => $tri,
            'type' => $type,
            'horizentale' => $horizentale,
            'verticale' => $verticale
        ));
        return $this->redirectToRoute('produits');
    }

    /**
     * @Route("/chercher" , name="chercher")
     */
    public function chercherAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findBy(
            [],
            ['id' => 'DESC']
        );
        $regions = $this->getDoctrine()->getRepository('AppBundle:Region')->findAll();
        $villes = $this->getDoctrine()->getRepository('AppBundle:Ville')->findAll();
        $em = $this->getDoctrine()->getManager();
        $motCle = $request->get('motCle');
        $categorie = $request->get('categorie');
        $region = $request->get('region');
        $tri = $request->get('tri');
        $type = $request->get('type');
        if($region!=''){
            $ville = $request->get('ville');
        }else{
            $ville = '';
        }
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $paginator = $this->get('knp_paginator');


        if (($motCle == '') && ($region == '') && ($categorie == '')) {
            if ($tri == 'prix') {
                $query = $em->createQuery(
                    'SELECT p from AppBundle:Produit p
                    WHERE p.type like :type
                    ORDER BY p.prix ASC'
                )->setParameter('type', '%'.$type.'%');
                $produits = $paginator->paginate(
                    $query,
                    $request->query->getInt('page', 1),
                    $request->query->getInt('limit', 9)
                );
            } else {

                $query = $em->createQuery(
                    'SELECT p from AppBundle:Produit p
                    WHERE p.type like :type
                    ORDER BY p.dateAjout DESC'
                )->setParameter('type', '%'.$type.'%');
                $produits = $paginator->paginate(
                    $query,
                    $request->query->getInt('page', 1),
                    $request->query->getInt('limit', 9)
                );
            }
                if($type=='Offre'){
                    $results = 'Toutes les offres';
                }elseif ($type=='Offre') {
                    $results = 'Toutes les demandes';
                }else{
                    $results = 'Toutes les annonces';
                }

            return $this->render('Textiles/produits.html.twig', array(
                'produits' => $produits,
                'categories' => $categories,
                'regions' => $regions,
                'villes' => $villes,
                'results' => $results,
                'choixCateg' => $categorie,
                'choixRegion' => $region,
                'choixVille' => $ville,
                'motCle' => $motCle,
                'tri' => $tri,
                'type' => $type,
                'verticale' => $verticale,
                'horizentale' => $horizentale
            ));
        }

        if ($tri == 'prix') {

            $query = $em->createQuery(
                'SELECT p FROM AppBundle:Produit p
                JOIN p.categorie c
                JOIN p.sousCategorie sc
                JOIN p.region r
                JOIN p.ville v
                WHERE r.nomRegion like :region
                AND v.nomVille like :ville
                AND (c.nomCategorie like :categorie
                OR sc.nomSousCategorie like :categorie)
                AND p.type like :type
                AND (p.nomprod like :motCle
                OR p.description like :motCle
                OR p.prix = :prix
                OR c.nomCategorie LIKE :motCle
                OR sc.nomSousCategorie LIKE :motCle)
                ORDER by p.prix')
            ->setParameter('categorie', '%' . $categorie . '%')
            ->setParameter('type', '%'.$type.'%')
            ->setParameter('region', '%' . $region . '%')
            ->setParameter('ville', '%' . $ville . '%')
            ->setParameter('prix', $motCle)
            ->setParameter('motCle', '%' . $motCle . '%');
        } else {
            $query = $em->createQuery(
                'SELECT p FROM AppBundle:Produit p
                JOIN p.categorie c
                JOIN p.sousCategorie sc
                JOIN p.region r
                JOIN p.ville v
                WHERE r.nomRegion like :region
                AND v.nomVille like :ville
                AND (c.nomCategorie like :categorie
                OR sc.nomSousCategorie like :categorie)
                AND p.type like :type
                AND (p.nomprod like :motCle
                OR p.description like :motCle
                OR p.prix = :prix
                OR c.nomCategorie LIKE :motCle
                OR sc.nomSousCategorie LIKE :motCle)
                ORDER by p.dateAjout DESC ')
            ->setParameter('categorie', '%' . $categorie . '%')
            ->setParameter('type', '%'.$type.'%')
            ->setParameter('region', '%' . $region . '%')
            ->setParameter('ville', '%' . $ville . '%')
            ->setParameter('prix', $motCle)
            ->setParameter('motCle', '%' . $motCle . '%');
        }


        $produits = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 9)
        );
        $messageMotCle = ' pour le mot clé ' . $motCle;
        $messageCategorie = ' dans la catégorie ' . $categorie;
        $messageRegion = ' dans ' . $region;
        if($ville!=''){
            $messageVille = ', ' . $ville;
        }else{
            $messageVille = '';
        }

        if ($motCle == '') {
            $messageMotCle = '';
        }
        if ($categorie == '') {
            $messageCategorie = '';
        }
        if ($region == '') {
            $messageRegion = '';
        }

        if ($type==null){
            $type = 'Annonce' ;
        }
        $results = $type.'s trouvés ' . $messageMotCle . $messageCategorie . $messageRegion . $messageVille;

        if ($produits->getTotalItemCount() == 0) {
            $results = 'Aucune '.strtolower ($type).' trouvée ' . $messageMotCle . $messageCategorie . $messageRegion. $messageVille;
        }
        return $this->render('Textiles/chercher.html.twig', array(
            'produits' => $produits,
            'categories' => $categories,
            'regions' => $regions,
            'villes' => $villes,
            'results' => $results,
            'choixCateg' => $categorie,
            'choixRegion' => $region,
            'choixVille' => $ville,
            'motCle' => $motCle,
            'tri' => $tri,
            'type' => $type,
            'horizentale' => $horizentale,
            'verticale' => $verticale
        ));


    }

    /**
     * @Route("/modifier/{id}" , name="modifier")
     * @param $id
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function modifierAction($id, Request $request)
    {
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $sousCategories = $this->getDoctrine()->getRepository('AppBundle:SousCategorie')->findAll();
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findAll();
        $regions = $this->getDoctrine()->getRepository('AppBundle:Region')->findAll();
        $villes = $this->getDoctrine()->getRepository('AppBundle:Ville')->findAll();

        $produit = $this->getDoctrine()
        ->getRepository('AppBundle:Produit')
        ->find($id);

        if (!($produit->getIdAnnonceur() == $this->getUser())) {
            $this->addFlash(
                'error',
                'Ceci n\'est pas votre annonce ! '
            );
            return $this->redirectToRoute('produits');
        }

        $produit->setNomProd($produit->getNomProd());
        $produit->setPrix($produit->getPrix());
        $produit->setDescription($produit->getDescription());
        $produit->setCategorie($produit->getCategorie());
        $produit->setSousCategorie($produit->getSousCategorie());
        $produit->setImage($produit->getImage());
        $produit->setRegion($produit->getRegion());
        $produit->setVille($produit->getVille());

        $old_image = $produit->getImage();
        $f = new File($this->getParameter('image_directory') . '/' . $old_image);
        $produit->setImage($f);

        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $nomprod = $form['nomprod']->getData();
            $prix = $form['prix']->getData();
            $description = $form['description']->getData();
            $categorie = $form['categorie']->getData();
            $image = $form['image']->getData();
            $region = $form['region']->getData();
            $sousCategorie = $request->get('sousCategorie');
            $ville = $request->get('ville');

            $em = $this->getDoctrine()->getManager();
            $produit = $em->getRepository('AppBundle:Produit')->find($id);

            /**
             * @var UploadedFile $file
             */
            $file = $produit->getImage();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'), $filename
            );

            $sousCategorie = $this->getDoctrine()->getRepository('AppBundle:SousCategorie')->findOneBy(['id' => $sousCategorie]);
            $ville = $this->getDoctrine()->getRepository('AppBundle:Ville')->findOneBy(['id' => $ville]);

            $produit->setNomProd($nomprod);
            $produit->setPrix($prix);
            $produit->setDescription($description);
            $produit->setCategorie($categorie);
            $produit->setSousCategorie($sousCategorie);
            $produit->setImage($filename);
            $produit->setRegion($region);
            $produit->setVille($ville);


            $path = $this->getParameter('image_directory') . '/' . $old_image;
            $fs = new Filesystem();
            $fs->remove(array($path));

            $em->flush();

            $this->addFlash(
                'notice',
                'Annonce modifié'
            );

            return $this->redirectToRoute('produits');
        }
        return $this->render('Textiles/modifier.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
            'old_image' => $old_image,
            'horizentale' => $horizentale,
            'verticale' => $verticale,
            'regions' => $regions,
            'villes' => $villes,
            'categories' => $categories,
            'sousCategories' => $sousCategories
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AppBundle:Produit')->find($id);
        $archive = new Archive();
        $archive->setNomprod($produit->getNomProd());
        $archive->setDateAjout($produit->getDateAjout());
        $archive->setIdAnnonceur($produit->getIdAnnonceur());
        $archive->setCategorie($produit->getCategorie());
        $archive->setSousCategorie($produit->getSousCategorie());
        $archive->setDescription($produit->getDescription());
        $archive->setImage($produit->getImage());
        $archive->setPrix($produit->getPrix());
        $archive->setRegion($produit->getRegion());
        $archive->setVille($produit->getVille());
        $archive->setType($produit->getType());
        $now = new\DateTime('now');
        $archive->setDateSuppression($now);

        if (!($produit->getIdAnnonceur() == $this->getUser())) {
            $this->addFlash(
                'error',
                'Ceci n\'est pas votre annonce ! '
            );
            return $this->redirectToRoute('produits');
        }

        $image = $produit->getImage();
        $path = $this->getParameter('image_directory') . '/' . $image;
        $pathArchive = $this->getParameter('archive_directory') . '/' . $image;

        $f = new Filesystem();
        $f->copy($path, $pathArchive, true);

        $fs = new Filesystem();
        $fs->remove(array($path));

        $em->remove($produit);
        $em->persist($archive);
        $em->flush();

        $this->addFlash(
            'notice',
            'Annonce supprimé'
        );

        return $this->redirectToRoute('produits');

    }
    

}
