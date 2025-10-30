<?php

namespace App\Entity;

use App\Repository\ParsedDateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParsedDateRepository::class)]
class ParsedDate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dateString = null;

    #[ORM\Column]
    private ?int $century = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    private ?string $month = null;

    #[ORM\Column]
    private ?int $day = null;

    #[ORM\Column(length: 255)]
    private ?string $dayOfWeek = null;

    #[ORM\Column]
    private ?int $parseCount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateString(): ?string
    {
        return $this->dateString;
    }

    public function setDateString(string $dateString): static
    {
        $this->dateString = $dateString;

        return $this;
    }

    public function getCentury(): ?int
    {
        return $this->century;
    }

    public function setCentury(int $century): static
    {
        $this->century = $century;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): static
    {
        $this->month = $month;

        return $this;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(string $dayOfWeek): static
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function getParseCount(): ?int
    {
        return $this->parseCount;
    }

    public function setParseCount(int $parseCount): static
    {
        $this->parseCount = $parseCount;

        return $this;
    }
}
