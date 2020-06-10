<?php


namespace App\Form\Handler;

use App\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class NoteHandler
{
    protected $request;
    private $em;

    public function __construct(RequestStack $request, EntityManagerInterface $em)
    {
        $this->request = $request;
        $this->em = $em;
    }

    public function process($data): Note
    {
        try {
            $fields = json_decode($this->request->getCurrentRequest()->getContent());
            $note = new Note();
            $note->setMatiere($fields->matiere);
            $note->setNote($fields->note);
            $note->setEleve($data);
            $this->em->persist($note);
            $this->em->flush();
            return $note;
        } catch (\Exception $e) {
            return $e;
        };
    }

}
