<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoffeeOrder
 *
 * @ORM\Table(name="coffee_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoffeeOrderRepository")
 */
class CoffeeOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="ApiUser", inversedBy="orders")
     * @ORM\JoinColumn(name="api_user_id", referencedColumnName="id")
     */
    private $apiUser;

    /**
     * @ORM\ManyToOne(targetEntity="Coffee", inversedBy="orders")
     * @ORM\JoinColumn(name="coffee_id", referencedColumnName="id")
     */
    private $coffee;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return CoffeeOrder
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return CoffeeOrder
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getApiUser()
    {
        return $this->apiUser;
    }

    /**
     * @param $apiUser
     * @return $this
     */
    public function setApiUser($apiUser)
    {
        $this->apiUser = $apiUser;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCoffee()
    {
        return $this->coffee;
    }

    /**
     * @param $coffee
     * @return $this
     */
    public function setCoffee($coffee)
    {
        $this->coffee = $coffee;

        return $this;
    }
}

