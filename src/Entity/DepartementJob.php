<?php

namespace App\Entity;

use App\Repository\DepartementJobRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartementJobRepository::class)
 */
class DepartementJob
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Job::class, inversedBy="departementJobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $job_id;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="departementJobs")
     */
    private $departement_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobId(): ?Job
    {
        return $this->job_id;
    }

    public function setJobId(?Job $job_id): self
    {
        $this->job_id = $job_id;

        return $this;
    }

    public function getDepartementId(): ?Departement
    {
        return $this->departement_id;
    }

    public function setDepartementId(?Departement $departement_id): self
    {
        $this->departement_id = $departement_id;

        return $this;
    }
}
