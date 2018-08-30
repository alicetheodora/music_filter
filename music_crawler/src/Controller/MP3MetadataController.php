<?php

namespace App\Controller;

use App\Entity\MP3Metadata;
use App\Form\MP3MetadataType;
use App\Repository\MP3MetadataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mp3metadata")
 */
class MP3MetadataController extends Controller
{
    /**
     * @Route("/", name="mp3metadataindex", methods="GET")
     */
    public function index(MP3MetadataRepository $mP3MetadataRepository): Response
    {
        return $this->render('mp3_metadata/index.html.twig', ['mp3metadatas' => $mP3MetadataRepository->findAll()]);
    }

    /**
     * @Route("/new", name="mp3metadatanew", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $mP3Metadatum = new MP3Metadata();
        $form = $this->createForm(MP3MetadataType::class, $mP3Metadatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mP3Metadatum);
            $em->flush();

            return $this->redirectToRoute('mp3metadataindex');
        }

        return $this->render('mp3_metadata/new.html.twig', [
            'mp3metadatum' => $mP3Metadatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mp3metadatashow", methods="GET")
     */
    public function show(MP3Metadata $mP3Metadatum): Response
    {
        return $this->render('mp3_metadata/show.html.twig', ['mp3metadatum' => $mP3Metadatum]);
    }

    /**
     * @Route("/{id}/edit", name="mp3metadataedit", methods="GET|POST")
     */
    public function edit(Request $request, MP3Metadata $mP3Metadatum): Response
    {
        $form = $this->createForm(MP3MetadataType::class, $mP3Metadatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mp3metadataedit', ['id' => $mP3Metadatum->getId()]);
        }

        return $this->render('mp3_metadata/edit.html.twig', [
            'mp3metadatum' => $mP3Metadatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mp3metadatadelete", methods="DELETE")
     */
    public function delete(Request $request, MP3Metadata $mP3Metadatum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mP3Metadatum->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mP3Metadatum);
            $em->flush();
        }

        return $this->redirectToRoute('mp3metadataindex');
    }
}
