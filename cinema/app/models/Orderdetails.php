<?php

class Orderdetails extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(column="productid", type="integer", length=11, nullable=true)
     */
    protected $productid;

    /**
     *
     * @var integer
     * @Column(column="orderid", type="integer", length=11, nullable=true)
     */
    protected $orderid;

    /**
     *
     * @var integer
     * @Column(column="quantity", type="integer", length=11, nullable=true)
     */
    protected $quantity;

    /**
     *
     * @var double
     * @Column(column="subtotal", type="double", length=18, nullable=true)
     */
    protected $subtotal;

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
     * Method to set the value of field productid
     *
     * @param integer $productid
     * @return $this
     */
    public function setProductid($productid)
    {
        $this->productid = $productid;

        return $this;
    }

    /**
     * Method to set the value of field orderid
     *
     * @param integer $orderid
     * @return $this
     */
    public function setOrderid($orderid)
    {
        $this->orderid = $orderid;

        return $this;
    }

    /**
     * Method to set the value of field quantity
     *
     * @param integer $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Method to set the value of field subtotal
     *
     * @param double $subtotal
     * @return $this
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

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
     * Returns the value of field productid
     *
     * @return integer
     */
    public function getProductid()
    {
        return $this->productid;
    }

    /**
     * Returns the value of field orderid
     *
     * @return integer
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * Returns the value of field quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Returns the value of field subtotal
     *
     * @return double
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cinema");
        $this->setSource("orderdetails");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'orderdetails';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Orderdetails[]|Orderdetails|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Orderdetails|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
