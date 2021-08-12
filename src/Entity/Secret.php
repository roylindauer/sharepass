<?php

namespace App\Entity;

use App\Repository\SecretRepository;
use Doctrine\ORM\Mapping as ORM;
use JaegerApp\Encrypt;

/**
 * @ORM\Entity(repositoryClass=SecretRepository::class)
 * @ORM\Table(name="secrets")
 */
class Secret
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=13, nullable=true)
     */
    private $access_key;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secret_data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccessKey(): ?string
    {
        return $this->access_key;
    }

    public function setAccessKey(?string $access_key): self
    {
        $this->access_key = $access_key;

        return $this;
    }

    public function getSecretData(): ?string
    {
        return $this->secret_data;
    }

    public function setSecretData(?string $secret_data): self
    {
        $encrypt = new Encrypt();
        $encrypt->setKey(config('encryption_key'));
        $this->secret_data = $encrypt->encode($secret_data);

        return $this;
    }
}
