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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;




class ConnexionController extends Controller
{
	/**
     * @Route("/login"  , name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $errors = $authenticationUtils->getLastAuthenticationError();

        $lastUserName = $authenticationUtils->getLastUsername();


        return $this->render('Textiles/login.html.twig', array(
            'errors' => $errors,
            'username' => $lastUserName,
            'verticale' => $verticale,
            'horizentale' => $horizentale
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/register", name="register")
     * @param UserPasswordEncoderInterface $encoder
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(UserPasswordEncoderInterface $encoder, Request $request, \Swift_Mailer $mailer)
    {
        $horizentale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Horizentale']);
        $verticale = $this->getDoctrine()->getRepository('AppBundle:Reglages')->findOneBy(['nom' => 'Verticale']);
        $em = $this->getDoctrine()->getManager();
        $annonceur = new Annonceur();

        $form = $this->createForm(AnnonceurType::class, $annonceur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
        	if($this->captchaverify($request->get('g-recaptcha-response'))){
            $annonceur->setPassword($encoder->encodePassword($annonceur, $annonceur->getPassword()));

            /**
             * @var UploadedFile $file
             */
            $file = $annonceur->getImageAnnonceur();
            if ($file!= null){
            	$filename = md5(uniqid()) . '.' . $file->guessExtension();
            	$file->move(
                $this->getParameter('profile_image_directory'), $filename
            	);
            	$annonceur->setImageAnnonceur($filename);
            }else{
            	$annonceur->setImageAnnonceur('defaut.png');
            }

            $annonceur->setConfirmed(false);

            $subject = 'Confirmation émail';
            $email = $annonceur->getEmailAnnonceur();

            $em->persist($annonceur);
            $em->flush();

            $transporter = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
              ->setUsername('affariat.textile@gmail.com')
              ->setPassword('affariat-textile@bec2018');

            $this->mailer = \Swift_Mailer::newInstance($transporter);

            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom('affariat.textile@gmail.com')
                ->setTo($email)
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->renderView('Textiles/confirmEmail.html.twig',array('annonceur' => $annonceur)));
            $mailer->send($message);

            $this->addFlash(
                'notice',
                'Bienvenue dans Affariat Textile, veuillez confirmer votre email pour pouvoir utiliser votre compte'
            );

            return $this->redirectToRoute('login');
    
          

        }else{
        	$this->addFlash(
                'error',
                'Captcha non valide !'
            );
        }

        }

        return $this->render('Textiles/register.html.twig', array(
            'form' => $form->createView(),
            'horizentale' => $horizentale,
            'verticale' => $verticale
        ));
    }


        function captchaverify($recaptcha){
            if ($recaptcha==''){
            	return false;
            }else{
            	return true;
            }
    }


    /**
     * @Route("/confirm/{id}", name="confirm")
     */
    public function confirmAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonceur = $this->getDoctrine()
        ->getRepository('AppBundle:Annonceur')
        ->find($id);

        if($annonceur==null){
            $this->addFlash(
                'error',
                'Ce compte n\'existe pas, créer un compte depuis cette page.'
            );
            return $this->redirectToRoute('register');
        }else{
            if($annonceur->getConfirmed()==true){
                $this->addFlash(
                'error',
                'Ce compte est déjà confirmé vous pouvez vous connecter.'
            );
            return $this->redirectToRoute('login');
            }
            $annonceur->setConfirmed(true);
            $em->flush();
            $this->addFlash(
                'notice',
                'Votre compte est confirmé vous pouvez vous connecter dés maintenant.'
            );
            return $this->redirectToRoute('login');
        }
    }
}
