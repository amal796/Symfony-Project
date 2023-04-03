<?php

namespace App\Entity;
use App\Repository\TerrainRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Gedmo\Mapping\Annotation as Gedmo; 
use Symfony\Component\Serializer\Annotation\Groups;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
/**
 * Terrain
 *
 * @ORM\Table(name="terrain")
 * @ORM\Entity(repositoryClass=TerrainRepository::class)
 */

class Terrain
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_terrain", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")

     */
    #[Groups("terrains")]
    private $idTerrain;

      /**
     * @Assert\NotBlank(message="image  doit etre non vide")
     * @ORM\Column(type="string", length=1000)
     * @Groups("post:read")
     */
    #[Groups("terrains")]
    private $imageTerrain;

      /**
     * @Assert\NotBlank(message="Description  doit etre non vide")
     * @ORM\Column(type="string", length=1000)
     * @Groups("post:read")
     */
    #[Groups("terrains")]
    private $descriptionTerrain;

    /**
     * @Assert\NotBlank(message="NOM  doit etre non vide")
     * @ORM\Column(type="string", length=1000)
     * @Groups("post:read")
     */
    #[Groups("terrains")]
    private $nomTerrain;

     /**
     * @Assert\NotBlank(message="Surface  doit etre non vide")
     * @ORM\Column(type="float", length=1000)
     * @Groups("post:read")
     */
    #[Groups("terrains")]
    private $surfaceTerrain;
      /**
     * @Assert\NotBlank(message="lieu  doit etre non vide")
     * @ORM\Column(type="string", length=1000)
     * @Groups("post:read")
     */
    #[Groups("terrains")]
    private $lieu;

    public function getIdTerrain(): ?int
    {
        return $this->idTerrain;
    }

    public function getImageTerrain()
    {
        return $this->imageTerrain;
    }

    public function setImageTerrain( $imageTerrain)
    {
        $this->imageTerrain = $imageTerrain;

        return $this;
    }

    public function getDescriptionTerrain(): ?string
    {
        return $this->descriptionTerrain;
    }

    public function setDescriptionTerrain(string $descriptionTerrain): self
    {
        $this->descriptionTerrain = $descriptionTerrain;

        return $this;
    }

    public function getNomTerrain(): ?string
    {
        return $this->nomTerrain;
    }

    public function setNomTerrain(string $nomTerrain): self
    {
        $this->nomTerrain = $nomTerrain;

        return $this;
    }

    public function getSurfaceTerrain(): ?string
    {
        return $this->surfaceTerrain;
    }

    public function setSurfaceTerrain(string $surfaceTerrain): self
    {
        $this->surfaceTerrain = $surfaceTerrain;

        return $this;
    }
    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

}
