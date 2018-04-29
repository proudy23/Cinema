<?php

class Scorder extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(column="orderDate", type="string", nullable=true)
     */
    protected $orderDate;

    /**
     *
     * @var string
     * @Column(column="deliveryCity", type="string", length=30, nullable=true)
     */
    protected $deliveryCity;

    /**
     *
     * @var string
     * @Column(column="deliveryCounty", type="string", length=30, nullable=true)
     */
    protected $deliveryCounty;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field orderDate
     *
     * @param string $orderDate
     * @return $this
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Method to set the value of field deliveryCity
     *
     * @param string $deliveryCity
     * @return $this
     */
    public function setDeliveryCity($deliveryCity)
    {
        $this->deliveryCity = $deliveryCity;

        return $this;
    }

    /**
     * Method to set the value of field deliveryCounty
     *
     * @param string $deliveryCounty
     * @return $this
     */
    public function setDeliveryCounty($deliveryCounty)
    {
        $this->deliveryCounty = $deliveryCounty;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field orderDate
     *
     * @return string
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * Returns the value of field deliveryCity
     *
     * @return string
     */
    public function getDeliveryCity()
    {
        return $this->deliveryCity;
    }

    /**
     * Returns the value of field deliveryCounty
     *
     * @return string
     */
    public function getDeliveryCounty()
    {
        return $this->deliveryCounty;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cinema");
        $this->setSource("scorder");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'scorder';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Scorder[]|Scorder|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Scorder|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
