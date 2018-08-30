<?php

namespace App\Controller;

use App\Entity\MP3Blob;
use App\Form\MP3BlobType;
use App\Repository\MP3BlobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mp3blob")
 */
class MP3BlobController extends Controller
{
    /**
     * @Route("/", name="mp3blobindex", methods="GET")
     */
    public function index(MP3BlobRepository $mP3BlobRepository): Response
    {
        return $this->render('mp3_blob/index.html.twig', ['mp3blobs' => $mP3BlobRepository->findAll()]);
    }

    /**
     * @Route("/new", name="mp3blobnew", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $mP3Blob = new MP3Blob();
        $form = $this->createForm(MP3BlobType::class, $mP3Blob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mP3Blob);
            $em->flush();

            return $this->redirectToRoute('mp3blobindex');
        }

        return $this->render('mp3_blob/new.html.twig', [
            'mp3blob' => $mP3Blob,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mp3blobshow", methods="GET")
     */
    public function show(MP3Blob $mP3Blob): Response
    {
        return $this->render('mp3_blob/show.html.twig', ['mp3blob' => $mP3Blob]);
    }

    /**
     * @Route("/{id}/edit", name="mp3blobedit", methods="GET|POST")
     */
    public function edit(Request $request, MP3Blob $mP3Blob): Response
    {
        $form = $this->createForm(MP3BlobType::class, $mP3Blob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mp3blobedit', ['id' => $mP3Blob->getId()]);
        }

        return $this->render('mp3_blob/edit.html.twig', [
            'mp3blob' => $mP3Blob,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mp3blobdelete", methods="DELETE")
     */
    public function delete(Request $request, MP3Blob $mP3Blob): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mP3Blob->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mP3Blob);
            $em->flush();
        }

        return $this->redirectToRoute('mp3blobindex');
    }
}
