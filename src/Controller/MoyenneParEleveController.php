<?php


namespace App\Controller;

use App\Entity\Eleve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


class MoyenneParEleveController extends AbstractController
{

    public function __invoke(Eleve $data )
    {
        $json = [
            "id" => $data->getId(),
            "nom" => $data->getNom(),
            "prenom" => $data->getPrenom(),
            "moyenne" => $this->getDoctrine()
                            ->getRepository(Eleve::class)
                            ->calculMoyenneParEleve($data->getId())
        ];

        return new JsonResponse($json);
    }
}
