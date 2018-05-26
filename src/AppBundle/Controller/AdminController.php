<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Archive;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Categorie;
use AppBundle\Entity\Region;
use AppBundle\Entity\Ville;
use AppBundle\Entity\SousCategorie;
use AppBundle\Form\ProduitType;
use AppBundle\Entity\Annonceur;
use AppBundle\Form\AnnonceurType;
use AppBundle\Form\CategorieType;
use AppBundle\Form\RegionType;
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
use Symfony\Component\HttpFoundation\Response;


class AdminController extends Controller
{
	/**
	* @Route("/admin-panel", name="adminDashboard")
	*/
	public function dashboardAction()
	{
		return $this->render('Textiles/adminDashboard.html.twig');
	}

	/**
	* @Route("/admin-panel/annonceurs", name="adminAnnonceurs")
	*/
	public function listAnnonceursAction()
	{
		$annonceurs = $this->getDoctrine()->getRepository('AppBundle:Annonceur')->findAll();
		return $this->render('Textiles/adminAnnonceurs.html.twig', ['annonceurs' => $annonceurs]);
	}

	/**
	* @Route("/admin-panel/annonces", name="adminAnnonces")
	*/
	public function listAnnoncesAction()
	{
		$annonces = $this->getDoctrine()->getRepository('AppBundle:Produit')->findAll();
		return $this->render('Textiles/adminAnnonces.html.twig',['annonces' => $annonces]);
	}

	/**
	* @Route("/admin-panel/categories", name="adminCategories")
	*/
	public function listCategoriesAction()
	{
		$categories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findAll();
		return $this->render('Textiles/adminCategories.html.twig',['categories' => $categories]);
	}

	/**
	* @Route("/admin-panel/regions", name="adminRegions")
	*/
	public function listRegionsAction()
	{
    $regions = $this->getDoctrine()->getRepository('AppBundle:Region')->findAll();
    return $this->render('Textiles/adminRegions.html.twig', ['regions' => $regions]);
  }

	/**
	* @Route("/admin-panel/reglages", name="adminReglages")
	*/
	public function reglagesAction(Request $request)
	{
    $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
    $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
    $form = $this->createFormBuilder()->getForm();
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $hor = $request->get('horizentale');
      $ver = $request->get('verticale');
      $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
      $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
      $em = $this->getDoctrine()->getManager();
      if($hor=='true'){
        $horizentale->setPublicite(1);
      } else{
        $horizentale->setPublicite(0);
      }
      if($ver=='true'){
        $verticale->setPublicite(1);
      } else{
        $verticale->setPublicite(0);
      }
      $em->flush();
       $this->addFlash(
                'notice',
                'Réglages changés avec succés'
      );
      return $this->redirectToRoute('adminDashboard');
    }
		return $this->render('Textiles/adminReglages.html.twig',['horizentale'=> $horizentale, 'verticale' => $verticale, 'form' => $form->createView()]);
	}

	/**
	* @Route("/admin-panel/archive", name="adminArchive")
	*/
	public function listArchiveAction()
	{
		$archive = $this->getDoctrine()->getRepository('AppBundle:Archive')->findAll();
		return $this->render('Textiles/adminArchive.html.twig',['archive' => $archive]);
	}

	/**
	* @Route("/admin-panel/annonces/{id}", name="AnnoncesAnnonceur")
	*/
	public function listAnnoncesAnnonceurAction($id)
	{
		$annonceur = $this->getDoctrine()->getRepository('AppBundle:Annonceur')->find($id);
		$annonces = $this->getDoctrine()->getRepository('AppBundle:Produit')->findby(
			['id_annonceur' => $annonceur]
		);
		return $this->render('Textiles/adminAnnoncesAnnonceur.html.twig', ['annonces' => $annonces, 'annonceur' => $annonceur]);
	}

	/**
	* @Route("/admin-panel/supprimer/annonceur/{id}", name="supprimerAnnonceur")
	*/
	public function supprimerAnnonceurAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$annonceur = $this->getDoctrine()->getRepository('AppBundle:Annonceur')->find($id);
		$image = $annonceur->getImageAnnonceur();
		$path = $this->getParameter('profile_image_directory') . '/' . $image;
		$fs = new Filesystem();
		$em->remove($annonceur);
		$em->flush();
		$fs->remove(array($path));

		$this->addFlash(
			'notice',
			'Annonceur supprimé'
		);

		return $this->redirectToRoute('adminAnnonceurs');

	}

    /**
	 * @Route("/admin-panel/supprimer/annonce/{id}", name="supprimerAnnonce")
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function supprimerAnnonceAction($id, Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$produit = $em->getRepository('AppBundle:Produit')->find($id);

    	$image = $produit->getImage();
    	$path = $this->getParameter('image_directory') . '/' . $image;

    	$fs = new Filesystem();
    	$fs->remove(array($path));

    	$em->remove($produit);
    	$em->flush();

    	$this->addFlash(
    		'notice',
    		'Annonce supprimée'
    	);

    	return $this->redirectToRoute('adminAnnonces');
    }

    /**
     * @Route("/admin-panel/categories/ajouter", name="ajouterCategorie")
     */
    public function ajouterCategorieAction(Request $request)
    {
     $categorie = new Categorie();
     $form = $this->createForm(CategorieType::class, $categorie);

     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {

      $nomCategorie = $form['nomCategorie']->getData();
      $image = $form['image']->getData();


            /**
             * @var UploadedFile $file
             */
            $file = $categorie->getImage();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
            	$this->getParameter('categorie_directory'), $filename
            );



            $categorie->setNomCategorie($nomCategorie);
            $categorie->setImage($filename);


            $em = $this->getDoctrine()->getManager();

            $em->persist($categorie);
            $sousCategorie = $request->get('sousCategorie');
            if($sousCategorie){
              foreach ($sousCategorie as $sc) {
                $sousCateg = new SousCategorie();
                $sousCateg->setNomSousCategorie($sc);
                $sousCateg->setCategorie($categorie);
                $em->persist($sousCateg);
              }
            }
            $em->flush();

            $this->addFlash(
            	'notice',
            	'Catégorie ajouté avec succés'
            );

            return $this->redirectToRoute('adminCategories',['sousCategorie' => $sousCategorie]);

          }


          return $this->render('Textiles/ajouterCategorie.html.twig', array(
           'form' => $form->createView(),
         ));
        }

    /**
     * @Route("/admin-panel/supprimer/categorie/{id}", name="supprimerCategorie")
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function supprimerCategorieAction($id, Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$categorie = $em->getRepository('AppBundle:Categorie')->find($id);

    	$image = $categorie->getImage();
    	$path = $this->getParameter('categorie_directory') . '/' . $image;


    	$fs = new Filesystem();
    	$fs->remove(array($path));

    	$em->remove($categorie);
    	$em->flush();

    	$this->addFlash(
    		'notice',
    		'Categorie supprimé'
    	);


    	return $this->redirectToRoute('adminCategories');
    }

        /**
     * @Route("/admin-panel/categorie/edit/{id}" , name="modifierCategorie")
     * @param $id
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
        public function modifierCategorieAction($id, Request $request)
        {
        	$categorie = $this->getDoctrine()
        	->getRepository('AppBundle:Categorie')
        	->find($id);

          $sousCategories = $this->getDoctrine()
          ->getRepository('AppBundle:SousCategorie')
          ->findby(['categorie' => $categorie]);

          $categorie->setNomCategorie($categorie->getNomCategorie());
          $categorie->setImage($categorie->getImage());

          $old_image = $categorie->getImage();
          $f = new File($this->getParameter('categorie_directory') . '/' . $old_image);
          $categorie->setImage($f);

          $form = $this->createForm(CategorieType::class, $categorie);

          $form->handleRequest($request);


          if ($form->isSubmitted() && $form->isValid()) {

            $nomCategorie = $form['nomCategorie']->getData();
            $image = $form['image']->getData();


            $em = $this->getDoctrine()->getManager();
            $categorie = $em->getRepository('AppBundle:Categorie')->find($id);
            if ($sousCategories) {
              foreach ($sousCategories as $sc) {
                $em->remove($sc);
              }
            }
            $sousCategorie = $request->get('sousCategorie');
            if($sousCategorie){
              foreach ($sousCategorie as $sc) {
                $sousCateg = new SousCategorie();
                $sousCateg->setNomSousCategorie($sc);
                $sousCateg->setCategorie($categorie);
                $em->persist($sousCateg);
              }
            }



            /**
             * @var UploadedFile $file
             */
            $file = $categorie->getImage();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
            	$this->getParameter('categorie_directory'), $filename
            );

            $categorie->setNomCategorie($nomCategorie);
            $categorie->setImage($filename);


            $path = $this->getParameter('categorie_directory') . '/' . $old_image;
            $fs = new Filesystem();
            $fs->remove(array($path));

            $em->flush();

            $this->addFlash(
            	'notice',
            	'Catégorie modifié'
            );

            return $this->redirectToRoute('adminCategories');

          }
          return $this->render('Textiles/modifierCategorie.html.twig', array(
           'categorie' => $categorie,
           'form' => $form->createView(),
           'old_image' => $old_image,
           'sousCategories' => $sousCategories
         ));
        }

    /**
     * @Route("/admin-panel/regions/ajouter", name="ajouterRegion")
     */
    public function ajouterRegionAction(Request $request)
    {
      $region = new Region();
      $form = $this->createForm(RegionType::class, $region);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

        $nomRegion = $form['nomRegion']->getData();

        $region->setNomRegion($nomRegion);

        $em = $this->getDoctrine()->getManager();

        $em->persist($region);
        $villes = $request->get('villes');
        if($villes){
          foreach ($villes as $v) {
            $ville = new Ville();
            $ville->setNomVille($v);
            $ville->setRegion($region);
            $em->persist($ville);
          }
        }
        $em->flush();

        $this->addFlash(
          'notice',
          'Région ajouté avec succés'
        );

        return $this->redirectToRoute('adminRegions',['villes' => $villes]);

      }


      return $this->render('Textiles/ajouterRegion.html.twig', array(
        'form' => $form->createView(),
      ));
    }


    /**
     * @Route("/admin-panel/region/edit/{id}" , name="modifierRegion")
     * @param $id
     * @param Request $request
     */
    public function modifierRegionAction($id, Request $request)
    {
      $region = $this->getDoctrine()
          ->getRepository('AppBundle:Region')
          ->find($id);

          $villes = $this->getDoctrine()
          ->getRepository('AppBundle:Ville')
          ->findby(['region' => $region]);

          $region->setNomRegion($region->getNomRegion());

          $form = $this->createForm(RegionType::class, $region);

          $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {

            $nomRegion = $form['nomRegion']->getData();

            $em = $this->getDoctrine()->getManager();
            $region = $em->getRepository('AppBundle:Region')->find($id);
            if ($villes) {
              foreach ($villes as $v) {
                $em->remove($v);
              }
            }
            $villes = $request->get('villes');
            if($villes){
              foreach ($villes as $v) {
                $ville = new Ville();
                $ville->setNomVille($v);
                $ville->setRegion($region);
                $em->persist($ville);
              }
            }
           

            $region->setNomRegion($nomRegion);

            $em->flush();

            $this->addFlash(
              'notice',
              'Région modifié'
            );

            return $this->redirectToRoute('adminRegions');

          }
          return $this->render('Textiles/modifierRegion.html.twig', array(
           'region' => $region,
           'form' => $form->createView(),
           'villes' => $villes
         ));
    }

       /**
     * @Route("/admin-panel/supprimer/region/{id}", name="supprimerRegion")
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
       public function supprimerRegionAction($id, Request $request)
       {

        $em = $this->getDoctrine()->getManager();
        $region = $em->getRepository('AppBundle:Region')->find($id);


        $em->remove($region);
        $em->flush();

        $this->addFlash(
          'notice',
          'Région supprimé'
        );

        return $this->redirectToRoute('adminRegions');
      }


    }
