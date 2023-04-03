<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Magasin
 *
 * @ORM\Table(name="magasin")
 * @ORM\Entity
 */
class Magasin
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_magasin", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMagasin;

    /**
     * @var int
     *
     * @ORM\Column(name="nom_magasin", type="integer", nullable=false)
     */
    private $nomMagasin;

    /**
     * @var int
     *
     * @ORM\Column(name="description_magasin", type="integer", nullable=false)
     */
    private $descriptionMagasin;

    /**
     * @var int
     *
     * @ORM\Column(name="lieu_magasin", type="integer", nullable=false)
     */
    private $lieuMagasin;

    public function getIdMagasin(): ?int
    {
        return $this->idMagasin;
    }

    public function getNomMagasin(): ?int
    {
        return $this->nomMagasin;
    }

    public function setNomMagasin(int $nomMagasin): self
    {
        $this->nomMagasin = $nomMagasin;

        return $this;
    }

    public function getDescriptionMagasin(): ?int
    {
        return $this->descriptionMagasin;
    }

    public function setDescriptionMagasin(int $descriptionMagasin): self
    {
        $this->descriptionMagasin = $descriptionMagasin;

        return $this;
    }

    public function getLieuMagasin(): ?int
    {
        return $this->lieuMagasin;
    }

    public function setLieuMagasin(int $lieuMagasin): self
    {
        $this->lieuMagasin = $lieuMagasin;

        return $this;
    }


}
