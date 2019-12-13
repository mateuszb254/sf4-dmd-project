<?php

namespace App\Download\Entity;

use App\Core\Util\Timestamp\Model\TimestampableTrait;
use App\User\Entity\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="transaction")
 * @ORM\MappedSuperclass()
 */
abstract class Transaction
{
    use TimestampableTrait;

    /**
     * @var int|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer" , nullable=false)
     */
    private $id;

    /**
     * @var string $paymentId
     *
     * @ORM\Column(name="payment_id", type="string", length=255)
     */
    private $paymentId;

    /**
     * @var UserInterface $user
     *
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User")
     * @ORM\JoinColumn(name="user")
     */
   private $user;
}
