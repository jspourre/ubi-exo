<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\NoteController;
use App\Controller\MoyenneDesNotesController;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *     "get",
 *     "put",
 *     "delete",
 *     "post_by_id_eleve"={
 *         "method"="POST",
 *         "path"="/notes/eleve/{id}/",
 *     "requirements"={"id"="\d+"},
 *         "controller"=NoteController::class,
 *     },
 *  },
 *     collectionOperations={
 *     "moyenne"={
 *         "method"="get",
 *         "path"="/notes/moyenne/",
 *         "controller"=MoyenneDesNotesController::class,
 *     }
 *     })
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type("float")
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      notInRangeMessage = "You must be between {{ min }}cm and {{ max }}",
     * )
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $matiere;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eleve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }
}
