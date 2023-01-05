<?php

namespace App\Entity;

use App\Repository\RDVRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RDVRepository::class)
 */
class RDV
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $creneau;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rDVs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=TypeConsultation::class, inversedBy="rDVs")
     */
    private $typeconsultation;

    /**
     * @ORM\ManyToOne(targetEntity=Docteur::class, inversedBy="rDVs")
     */
    private $medecin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreneau(): ?\DateTimeInterface
    {
        return $this->creneau;
    }

    public function setCreneau(?\DateTimeInterface $creneau): self
    {
        $this->creneau = $creneau;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTypeconsultation(): ?TypeConsultation
    {
        return $this->typeconsultation;
    }

    public function setTypeconsultation(?TypeConsultation $typeconsultation): self
    {
        $this->typeconsultation = $typeconsultation;

        return $this;
    }

    public function getMedecin(): ?Docteur
    {
        return $this->medecin;
    }

    public function setMedecin(?Docteur $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }
}
