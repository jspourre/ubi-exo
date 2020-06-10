<?php


namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Note;
use App\Form\Handler\NoteHandler;

class NoteController
{
    private $noteHandler;

    public function __construct(NoteHandler $noteHandler)
    {
        $this->noteHandler = $noteHandler;
    }

    public function __invoke(Eleve $data ): Note
    {
        return $this->noteHandler->process($data);
    }
}
