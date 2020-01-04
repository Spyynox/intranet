<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentUserRepository")
 */
class StudentUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Matter", inversedBy="studentUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $studentMatter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="studentUsers")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudentMatter(): ?Matter
    {
        return $this->studentMatter;
    }

    public function setStudentMatter(?Matter $studentMatter): self
    {
        $this->studentMatter = $studentMatter;

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
}
