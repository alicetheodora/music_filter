<?php

namespace App\Controller;

use App\Entity\MP3File;
use App\Form\MP3FileType;
use App\FS\FileSystem;
use App\FS\MP3Metadata;
use App\Repository\MP3FileRepository;
use App\Service\FilePopulate;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;
use App\Entity\MP3Metadata as MD;
use App\Entity\MP3Blob as MB;
/**
 * @Route("/mp3file")
 */
class MP3FileController extends Controller
{

    /**
     * @Route("/join", name="mp3filejoin", methods="GET")
     */
    public function showJoinEntity(Request $request): Response
    {

        $mp3files = $this->getDoctrine()->getRepository(MP3File::class)->findOneByIdJoinedToCategory();

        return $this->render('joinEntity.html.twig',['mp3files'=>$mp3files]);

    }

    /**
     * @Route("/search/{name}", name="mp3filesearch", methods="GET")
     */
    public function searchEntity(Request $request,string $name): Response
    {
        $mp3files = $this->getDoctrine()->getRepository(MP3File::class)->searchRow($name);

        return $this->render('joinEntity.html.twig',['mp3files'=>$mp3files]);

    }

    /**
     * @Route("/", name="mp3fileindex", methods="GET")
     */
    public function index(MP3FileRepository $mP3FileRepository): Response
    {

        $file = new MP3File();

        return $this->render('mp3_file/index.html.twig', ['mp3files' => $mP3FileRepository->findAll()]);
    }

    /**
     * @Route("/new", name="mp3filenew", methods="GET|POST")
     */
    public function new(Request $request, FileUploader $uploader, FilePopulate $populate): Response
    {
        $mP3File = new MP3File();

        $form = $this->createForm(MP3FileType::class, $mP3File,['modify_file' => true]);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($mP3File);
            $em->flush();

            return $this->redirectToRoute('mp3filejoin');
        }

        return $this->render('mp3_file/new.html.twig', [
            'mp3file' => $mP3File,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mp3fileshow", methods="GET")
     */
    public function show(MP3File $mP3File): Response
    {
        return $this->render('mp3_file/show.html.twig', ['mp3file' => $mP3File]);
    }

    /**
     * @Route("/{id}/edit", name="mp3fileedit", methods="GET|POST")
     */
    public function edit(Request $request, MP3File $mP3File): Response
    {

        $form = $this->createForm(MP3FileType::class, $mP3File);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mp3fileedit', ['id' => $mP3File->getId()]);
        }

        return $this->render('mp3_file/edit.html.twig', [
            'mp3file' => $mP3File,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mp3filedelete", methods="DELETE")
     */
    public function delete(Request $request, MP3File $mP3File): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mP3File->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mP3File);
            $em->flush();
        }

        return $this->redirectToRoute('mp3fileindex');
    }
}
