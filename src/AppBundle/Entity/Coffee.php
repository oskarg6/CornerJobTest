<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Coffee
 *
 * @ORM\Table(name="coffee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoffeeRepository")
 */
class Coffee
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="intensity", type="integer")
     */
    private $intensity;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @ORM\OneToMany(targetEntity="CoffeeOrder", mappedBy="coffees")
     */
    private $orders;

    function __construct()
    {
        $this->orders = new ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     *
     * @return Coffee
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set intensity
     *
     * @param integer $intensity
     *
     * @return Coffee
     */
    public function setIntensity($intensity)
    {
        $this->intensity = $intensity;

        return $this;
    }

    /**
     * Get intensity
     *
     * @return int
     */
    public function getIntensity()
    {
        return $this->intensity;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Coffee
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Coffee
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    public function addOrder(CoffeeOrder $order)
    {
        $this->orders[] = $order;
        $order->setApiUser($this);

        return $this;
    }

    public function removeOrder(CoffeeOrder $order)
    {
        $this->orders->removeElement($order);
        $order->setApiUser(null);

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'intensity' => $this->getIntensity(),
            'price' => $this->getPrice(),
            'stock' => $this->getStock()
        ];
    }
}

