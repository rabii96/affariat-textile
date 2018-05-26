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


class ProfilController extends Controller
{
	/**
     *
     * @Route("/profil/mesannonces" , name="mesAnnonces")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profilAnnoncesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $annonceur = $this->getUser();
        $idAnnoceur = $annonceur->getID();
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $query = $em->createQuery(
            'SELECT p FROM AppBundle:Produit p
            JOIN p.id_annonceur a
            WHERE a.id = :id
            ORDER BY p.dateAjout DESC ')
        ->setParameter('id', $idAnnoceur);
        $produits = $query->getResult();
        $results = 'Mes annonces :';
        return $this->render('Textiles/profilAnnonces.html.twig', array(
            'produits' => $produits,
            'results' => $results,
            'horizentale' => $horizentale,
            'verticale' => $verticale
        ));
    }

    /**
     * @Route("/profil/reglages",name="reglages")
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profilReglagesAction(Request $request)
    {
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $annonceur = $this->getUser();
        $annonceur->setNomAnnonceur($annonceur->getNomAnnonceur());
        $annonceur->setNumAnnonceur($annonceur->getNumAnnonceur());
        $annonceur->setEmailAnnonceur($annonceur->getEmailAnnonceur());
        $annonceur->setImageAnnonceur($annonceur->getImageAnnonceur());
        $annonceur->setUsername($annonceur->getUsername());

        $old_image = $annonceur->getImageAnnonceur();


        $form = $this->createFormBuilder($annonceur)
        ->add('username', TextType::class, array('label' => 'Username :', 'attr' => array('class' => 'form-control', 'style' => 'margin-button:15px ')))
        ->add('nomAnnonceur', TextType::class, array('label' => 'Nom :', 'attr' => array('class' => 'form-control', 'style' => 'margin-button:15px ')))
        ->add('prenomAnnonceur', TextType::class, array('label' => 'Prénom :', 'attr' => array('class' => 'form-control', 'style' => 'margin-button:15px ')))
        ->add('emailAnnonceur', EmailType::class, array('label' => 'Email :', 'attr' => array('class' => 'form-control', 'style' => 'margin-button:15px ')))
        ->add('numAnnonceur', IntegerType::class, array('label' => 'Téléphone :', 'attr' => array('class' => 'form-control', 'style' => 'margin-button:15px ')))
        ->add('imageAnnonceur', FileType::class, array('data_class' => null, 'label' => 'Image :', 'attr' => array('class' => 'form-control', 'style' => 'margin-button:15px; width:168px ')))
        ->add('confirmer', SubmitType::class, array('label' => 'Confirmer', 'attr' => array('class' => 'btn btn-success btn-block', 'style' => 'margin-button:25px; margin-top:15px;')))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form['username']->getData();
            $nomAnnonceur = $form['nomAnnonceur']->getData();
            $emailAnnonceur = $form['emailAnnonceur']->getData();
            $numAnnonceur = $form['numAnnonceur']->getData();
            $imageAnnonceur = $form['imageAnnonceur']->getData();

            /**
             * @var UploadedFile $file
             */
            $file = $imageAnnonceur;
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('profile_image_directory'), $filename
            );

            $path = $this->getParameter('profile_image_directory') . '/' . $old_image;
            $fs = new Filesystem();
            $fs->remove(array($path));

            $em = $this->getDoctrine()->getManager();
            $annonceur = $this->getDoctrine()->getRepository('AppBundle:Annonceur')
            ->find($this->getUser()->getId());
            $annonceur->setNomAnnonceur($nomAnnonceur);
            $annonceur->setNumAnnonceur($numAnnonceur);
            $annonceur->setEmailAnnonceur($emailAnnonceur);
            $annonceur->setImageAnnonceur($filename);
            $annonceur->setUsername($username);


            $em->flush();

            $this->addFlash(
                'notice',
                'Profil mis à jour'
            );

            return $this->redirectToRoute('mesAnnonces');

        }
        return $this->render('Textiles/profilReglages.html.twig', array(
            'form' => $form->createView() ,
            'annonceur' => $annonceur,
            'horizentale' => $horizentale,
            'verticale' => $verticale
        ));

    }

    /**
     * @Route(path="/profil/annoncesSupprimees", name="annoncesSupprimees")
     */
    public function annoncesSupprimésAction()
    {
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $em = $this->getDoctrine()->getManager();
        $annonceur = $this->getUser();
        $idAnnoceur = $annonceur->getID();
        $query = $em->createQuery(
            'SELECT a FROM AppBundle:Archive a
            JOIN a.id_annonceur p
            WHERE p.id = :id
            ORDER BY a.dateAjout DESC ')
        ->setParameter('id', $idAnnoceur);
        $produits = $query->getResult();
        $results = 'Annonces supprimées :';
        return $this->render('Textiles/annoncesSupprimees.html.twig', array(
            'produits' => $produits,
            'results' => $results,
            'horizentale' => $horizentale,
            'verticale' => $verticale
        ));
    }

    /**
     * @Route(path="/produit/supprime/{id}", name="produitSupprime")
     */
    public function produitSupprimeAction($id)
    {
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $produit = $this->getDoctrine()
        ->getRepository('AppBundle:Archive')
        ->find($id);
        if ($produit) {
            return $this->render('Textiles/produitSupprime.html.twig', array(
                'produit' => $produit,
                'horizentale' => $horizentale,
                'verticale' => $verticale
            ));
        } else {
            $this->addFlash(
                'error',
                'Produit Introuvable'
            );
            return $this->redirectToRoute('annoncesSupprimees');
        }
    }

    /**
     * @Route(path="/supprimer-definitivement/{id}", name="definitivement")
     */
    public function supprimerDefinitivementAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $archive = $em->getRepository('AppBundle:Archive')->find($id);
        if (!$archive) {
            $this->addFlash(
                'error',
                'Ce produit n\'existe pas !'
            );
            return $this->redirectToRoute('annoncesSupprimees');
        }
        if($this->getUser()->getRoles()[0]=='ROLE_ADMIN'){

            $image = $archive->getImage();
            $path = $this->getParameter('archive_directory') . '/' . $image;


            $fs = new Filesystem();
            $fs->remove(array($path));

            $em->remove($archive);
            $em->flush();

            $this->addFlash(
                'notice',
                'Annonce supprimée définitivement'
            );
            return $this->redirectToRoute('adminArchive');
        }
        elseif (!($archive->getIdAnnonceur() == $this->getUser())) {
            $this->addFlash(
                'error',
                'Ceci n\'est pas votre annonce ! '
            );
            return $this->redirectToRoute('produits');
        } else{
              $image = $archive->getImage();
            $path = $this->getParameter('archive_directory') . '/' . $image;


            $fs = new Filesystem();
            $fs->remove(array($path));

            $em->remove($archive);
            $em->flush();

            $this->addFlash(
                'notice',
                'Annonce supprimée définitivement'
            );
            return $this->redirectToRoute('annoncesSupprimees');
        }

    }

    /**
     * @Route(path="/restaurer/{id}", name="restaurer")
     */
    public function restaurerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $archive = $em->getRepository('AppBundle:Archive')->find($id);
        if (!$archive) {
            $this->addFlash(
                'error',
                'Ce produit n\'existe pas !'
            );
            return $this->redirectToRoute('annoncesSupprimees');
        }

        if (!($archive->getIdAnnonceur() == $this->getUser())) {
            $this->addFlash(
                'error',
                'Ceci n\'est pas votre annonce ! '
            );
            return $this->redirectToRoute('produits');
        }

        $produit = new Produit();
        $produit->setNomprod($archive->getNomProd());
        $produit->setRegion($archive->getRegion());
        $produit->setVille($archive->getVille());
        $produit->setPrix($archive->getPrix());
        $produit->setImage($archive->getImage());
        $produit->setDescription($archive->getDescription());
        $produit->setIdAnnonceur($archive->getIdAnnonceur());
        $produit->setCategorie($archive->getCategorie());
        $produit->setSousCategorie($archive->getSousCategorie());
        $produit->setType($archive->getType());
        $now = new\DateTime('now');
        $produit->setDateAjout($now);

        $image = $produit->getImage();
        $path = $this->getParameter('image_directory') . '/' . $image;
        $pathArchive = $this->getParameter('archive_directory') . '/' . $image;

        $f = new Filesystem();
        $f->copy($pathArchive, $path, true);

        $fs = new Filesystem();
        $fs->remove(array($pathArchive));

        $em->remove($archive);
        $em->persist($produit);
        $em->flush();

        $this->addFlash(
            'notice',
            'Annonce restaurée avec succés'
        );

        return $this->redirectToRoute('mesAnnonces');
    }


    /**
     * @Route("/profil/reglages/password",name="reglagesPassword")
     * @param UserPasswordEncoderInterface $encoder
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profilPasswordAction(UserPasswordEncoderInterface $encoder, Request $request)
    {
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $annonceur = $this->getUser();
        $annonceur->setPassword($annonceur->getPassword());


        $form = $this->createFormBuilder($annonceur)
        ->add('old', PasswordType::class, array('label' => 'Ancien mot de passe :', "mapped" => false, 'attr' => array('class' => 'form-control', 'style' => 'margin-button:15px ')))
        ->add('new', RepeatedType::class, array('type' => PasswordType::class, "mapped" => false, 'invalid_message' => 'Les mots de passes sont différents',
            'options' => array('attr' => array('class' => 'form-control', 'style' => 'margin-button:15px ')),
            'required' => true,
            'first_options' => array('label' => 'Nouveau mot de passe :'),
            'second_options' => array('label' => 'Confirmer Mot de passe :')))
        ->add('confirmer', SubmitType::class, array('label' => 'Confirmer', 'attr' => array('class' => 'btn btn-success btn-block', 'style' => 'margin-button:25px; margin-top:15px;')))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old = $form['old']->getData();
            $new = $form['new']->getData();


            $em = $this->getDoctrine()->getManager();
            $annonceur = $this->getDoctrine()->getRepository('AppBundle:Annonceur')
            ->find($this->getUser()->getId());
            if ($encoder->isPasswordValid($annonceur, $old)) {
                $annonceur->setPassword($encoder->encodePassword($annonceur, $new));
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Mot de passe modifié avec succés'
                );
                return $this->redirectToRoute('mesAnnonces');
            }else{
                $this->addFlash(
                    'error',
                    'L\'ancien mot de passe est incorrect !'
                );
                return $this->redirectToRoute('reglagesPassword');
            }

        }
        return $this->render('Textiles/profilPassword.html.twig', array(
            'form' => $form->createView(),
            'horizentale' => $horizentale,
            'verticale' => $verticale
        ));

    }
}
