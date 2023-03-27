<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PokemonRepository::class)
 */
class Pokemon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(message="Champs requis.")
     * @Assert\Length(max=30, maxMessage="Le nom du pokemon doit être inférieur à {{ limit }}")
     */
    private $nom;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\Range(min=1, max=150, minMessage="La valeur doit être supérieur à {{ min }}", maxMessage="La valeur doit être inférieur à {{ max }} ")
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, minMessage="La valeur doit être supérieur à {{ limit }}")

     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity=Types::class, inversedBy="pokemon")
     * @ORM\JoinColumn(name="types_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $types;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="pokemon")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getTypes(): ?Types
    {
        return $this->types;
    }

    public function setTypes(?Types $types): self
    {
        $this->types = $types;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addPokemon($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removePokemon($this);
        }

        return $this;
    }
}
