<?php

namespace App\Entity;

use App\Repository\StatisticsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatisticsRepository::class)
 */
class Statistics
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /** 
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $countInsert;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountInsert(): ?int
    {
        return $this->countInsert;
    }

    public function setCountInsert(int $countInsert): self
    {
        $this->countInsert = $countInsert;

        return $this;
    }

    public function incrementeCount(): int{
        return $this->countInsert+=1;
    }
}