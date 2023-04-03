<?php

namespace App\Entity;
use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="id_utilisateur", columns={"id_utilisateur"}), @ORM\Index(name="id_terrain", columns={"id_terrain"})})
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReservation;

    /**
     * @Assert\NotBlank(message="Nombre de membre  doit etre non vide")
     * @ORM\Column(type="integer", length=1000)
     */
    private $nbrMembre;

    /**
     * @Assert\NotBlank(message="Date Début  doit etre non vide")
     * @ORM\Column(type="date", length=1000)
     */
    private $dateDebut;

    /**
     * @Assert\NotBlank(message="Date Fin  doit etre non vide")
     * @ORM\Column(type="date", length=1000)
     */
    private $dateFin;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id_utilisateur")
     * })
     * @Assert\NotBlank(message="Utilisateur  doit etre non vide")
     */
    private $idUtilisateur;

    /**
     * @var \Terrain
     *
     * @ORM\ManyToOne(targetEntity="Terrain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_terrain", referencedColumnName="id_terrain")
     * })
     * @Assert\NotBlank(message="Terrain  doit etre non vide")
     */
    private $idTerrain;

    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }

    public function getNbrMembre(): ?int
    {
        return $this->nbrMembre;
    }

    public function setNbrMembre(int $nbrMembre): self
    {
        $this->nbrMembre = $nbrMembre;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getIdTerrain(): ?Terrain
    {
        return $this->idTerrain;
    }

    public function setIdTerrain(?Terrain $idTerrain): self
    {
        $this->idTerrain = $idTerrain;

        return $this;
    }


}
