<?php

namespace App\Entity;

use App\Repository\CopieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CopieRepository::class)
 */
class Copie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      notInRangeMessage = "La note finale doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $noteFinale;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\Choice({"ADM", "MOY", "AJ"})
     */
    private $mentionFinale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $correcteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vague;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $noteD1;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $noteD2;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $noteD3;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $noteTableur;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $noteTraitementTexte;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $notePresentationAO;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $noteD4;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $noteD5;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\Choice({"ADM", "MOY", "AJ"})
     */
    private $mentionD1;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\Choice({"ADM", "MOY", "AJ"})
     */
    private $mentionD2;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\Choice({"ADM", "MOY", "AJ"})
     */
    private $mentionD3;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\Choice({"ADM", "MOY", "AJ"})
     */
    private $mentionD4;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\Choice({"ADM", "MOY", "AJ"})
     */
    private $mentionD5;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="copies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;

    /**
     * @ORM\ManyToOne(targetEntity=Salle::class, inversedBy="copies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $salle;

    /**
     * @ORM\ManyToOne(targetEntity=Epreuve::class, inversedBy="copies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $epreuve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoteFinale(): ?float
    {
        return $this->noteFinale;
    }

    public function setNoteFinale(float $noteFinale): self
    {
        $this->noteFinale = $noteFinale;

        return $this;
    }

    public function getMentionFinale(): ?string
    {
        return $this->mentionFinale;
    }

    public function setMentionFinale(string $mentionFinale): self
    {
        $this->mentionFinale = $mentionFinale;

        return $this;
    }

    public function getCorrecteur(): ?string
    {
        return $this->correcteur;
    }

    public function setCorrecteur(string $correcteur): self
    {
        $this->correcteur = $correcteur;

        return $this;
    }

    public function getVague(): ?string
    {
        return $this->vague;
    }

    public function setVague(string $vague): self
    {
        $this->vague = $vague;

        return $this;
    }

    public function getNoteD1(): ?float
    {
        return $this->noteD1;
    }

    public function setNoteD1(float $noteD1): self
    {
        $this->noteD1 = $noteD1;

        return $this;
    }

    public function getNoteD2(): ?float
    {
        return $this->noteD2;
    }

    public function setNoteD2(float $noteD2): self
    {
        $this->noteD2 = $noteD2;

        return $this;
    }

    public function getNoteD3(): ?float
    {
        return $this->noteD3;
    }

    public function setNoteD3(float $noteD3): self
    {
        $this->noteD3 = $noteD3;

        return $this;
    }

    public function getNoteTableur(): ?float
    {
        return $this->noteTableur;
    }

    public function setNoteTableur(float $noteTableur): self
    {
        $this->noteTableur = $noteTableur;

        return $this;
    }

    public function getNoteTraitementTexte(): ?float
    {
        return $this->noteTraitementTexte;
    }

    public function setNoteTraitementTexte(float $noteTraitementTexte): self
    {
        $this->noteTraitementTexte = $noteTraitementTexte;

        return $this;
    }

    public function getNotePresentationAO(): ?float
    {
        return $this->notePresentationAO;
    }

    public function setNotePresentationAO(float $notePresentationAO): self
    {
        $this->notePresentationAO = $notePresentationAO;

        return $this;
    }

    public function getNoteD4(): ?float
    {
        return $this->noteD4;
    }

    public function setNoteD4(float $noteD4): self
    {
        $this->noteD4 = $noteD4;

        return $this;
    }

    public function getNoteD5(): ?float
    {
        return $this->noteD5;
    }

    public function setNoteD5(float $noteD5): self
    {
        $this->noteD5 = $noteD5;

        return $this;
    }

    public function getMentionD1(): ?string
    {
        return $this->mentionD1;
    }

    public function setMentionD1(string $mentionD1): self
    {
        $this->mentionD1 = $mentionD1;

        return $this;
    }

    public function getMentionD2(): ?string
    {
        return $this->mentionD2;
    }

    public function setMentionD2(string $mentionD2): self
    {
        $this->mentionD2 = $mentionD2;

        return $this;
    }

    public function getMentionD3(): ?string
    {
        return $this->mentionD3;
    }

    public function setMentionD3(string $mentionD3): self
    {
        $this->mentionD3 = $mentionD3;

        return $this;
    }

    public function getMentionD4(): ?string
    {
        return $this->mentionD4;
    }

    public function setMentionD4(string $mentionD4): self
    {
        $this->mentionD4 = $mentionD4;

        return $this;
    }

    public function getMentionD5(): ?string
    {
        return $this->mentionD5;
    }

    public function setMentionD5(string $mentionD5): self
    {
        $this->mentionD5 = $mentionD5;

        return $this;
    }

    public function getEpreuve(): ?Epreuve
    {
        return $this->epreuve;
    }

    public function setEpreuve(?Epreuve $epreuve): self
    {
        $this->epreuve = $epreuve;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }
}
