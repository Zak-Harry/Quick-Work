<?php

namespace App\Entity;

use App\Repository\PlannedWorkDaysRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlannedWorkDaysRepository::class)
 */
class PlannedWorkDays
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startshift;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endshift;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startlunch;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endlunch;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $hoursplanned;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updadedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartshift(): ?\DateTimeInterface
    {
        return $this->startshift;
    }

    public function setStartshift(\DateTimeInterface $startshift): self
    {
        $this->startshift = $startshift;

        return $this;
    }

    public function getEndshift(): ?\DateTimeInterface
    {
        return $this->endshift;
    }

    public function setEndshift(\DateTimeInterface $endshift): self
    {
        $this->endshift = $endshift;

        return $this;
    }

    public function getStartlunch(): ?\DateTimeInterface
    {
        return $this->startlunch;
    }

    public function setStartlunch(\DateTimeInterface $startlunch): self
    {
        $this->startlunch = $startlunch;

        return $this;
    }

    public function getEndlunch(): ?\DateTimeInterface
    {
        return $this->endlunch;
    }

    public function setEndlunch(\DateTimeInterface $endlunch): self
    {
        $this->endlunch = $endlunch;

        return $this;
    }

    public function getHoursplanned(): ?\DateTimeInterface
    {
        return $this->hoursplanned;
    }

    public function setHoursplanned(?\DateTimeInterface $hoursplanned): self
    {
        $this->hoursplanned = $hoursplanned;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdadedAt(): ?\DateTimeInterface
    {
        return $this->updadedAt;
    }

    public function setUpdadedAt(?\DateTimeInterface $updadedAt): self
    {
        $this->updadedAt = $updadedAt;

        return $this;
    }
}