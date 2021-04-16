<?php

namespace App\Entity;

use App\Repository\EpreuveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EpreuveRepository::class)
 */
class Epreuve
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
     *      max = 5,
     *      notInRangeMessage = "La barre doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $barre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomUFR;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 1950,
     *      max = 2021,
     *      notInRangeMessage = "L'année doit être comprise entre {{ min }} et {{ max }}."
     * )
     */
    private $annee;

    /**
     * @ORM\OneToMany(targetEntity=Copie::class, mappedBy="epreuve")
     */
    private $copies;

    public function __construct()
    {
        $this->copies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarre(): ?float
    {
        return $this->barre;
    }

    public function setBarre(float $barre): self
    {
        $this->barre = $barre;

        return $this;
    }

    public function getNomUFR(): ?string
    {
        return $this->nomUFR;
    }

    public function setNomUFR(string $nomUFR): self
    {
        $this->nomUFR = $nomUFR;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return Collection|Copie[]
     */
    public function getCopies(): Collection
    {
        return $this->copies;
    }

    public function addCopy(Copie $copy): self
    {
        if (!$this->copies->contains($copy)) {
            $this->copies[] = $copy;
            $copy->setEtudiant($this);
        }

        return $this;
    }

    public function removeCopy(Copie $copy): self
    {
        if ($this->copies->removeElement($copy)) {
            // set the owning side to null (unless already changed)
            if ($copy->getEtudiant() === $this) {
                $copy->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getTauxRéussite(): ?float
    {
        $copiesAdmisses = $this->copies->filter(function (Copie $cp) {
            return $cp->getMentionFinale() == 'ADM';
        });

        if ($this->copies->count() > 0) {
            return ($copiesAdmisses->count() / $this->copies->count()) * 100;
        }
        return null;
    }
}
