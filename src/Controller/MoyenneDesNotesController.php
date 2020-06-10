<?php


namespace App\Controller;


use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class MoyenneDesNotesController extends AbstractController
{

    public function __invoke()
    {
        $json = [
            "moyenne" => $this->getDoctrine()
                            ->getRepository(Note::class)
                            ->getMoyenne()
        ];

        return new JsonResponse($json);
    }
}
