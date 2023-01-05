<?php

namespace App\Entity;

use App\Repository\TypeConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeConsultationRepository::class)
 */
class TypeConsultation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\ManyToMany(targetEntity=Docteur::class, inversedBy="typeConsultations")
     */
    private $medecin;

    /**
     * @ORM\OneToMany(targetEntity=RDV::class, mappedBy="typeconsultation")
     */
    private $rDVs;

    public function __construct()
    {
        $this->medecin = new ArrayCollection();
        $this->rDVs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->id . '-' . $this->getLibelle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * @return Collection<int, Docteur>
     */
    public function getMedecin(): Collection
    {
        return $this->medecin;
    }

    public function addMedecin(Docteur $medecin): self
    {
        if (!$this->medecin->contains($medecin)) {
            $this->medecin[] = $medecin;
        }

        return $this;
    }

    public function removeMedecin(Docteur $medecin): self
    {
        $this->medecin->removeElement($medecin);

        return $this;
    }

    /**
     * @return Collection<int, RDV>
     */
    public function getRDVs(): Collection
    {
        return $this->rDVs;
    }

    public function addRDV(RDV $rDV): self
    {
        if (!$this->rDVs->contains($rDV)) {
            $this->rDVs[] = $rDV;
            $rDV->setTypeconsultation($this);
        }

        return $this;
    }

    public function removeRDV(RDV $rDV): self
    {
        if ($this->rDVs->removeElement($rDV)) {
            // set the owning side to null (unless already changed)
            if ($rDV->getTypeconsultation() === $this) {
                $rDV->setTypeconsultation(null);
            }
        }

        return $this;
    }
}
