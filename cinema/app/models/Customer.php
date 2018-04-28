<?php

class Customer extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(column="firstname", type="string", length=30, nullable=true)
     */
    public $firstname;

    /**
     *
     * @var string
     * @Column(column="surname", type="string", length=30, nullable=true)
     */
    public $surname;

    /**
     *
     * @var string
     * @Column(column="membertype", type="string", length=6, nullable=true)
     */
    public $membertype;

    /**
     *
     * @var string
     * @Column(column="dateofbirth", type="string", nullable=true)
     */
    public $dateofbirth;

    /**
     *
     * @var string
     * @Column(column="address", type="string", length=45, nullable=true)
     */
    public $address;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cinema");
        $this->setSource("customer");
        $this->hasMany('id', 'Booking', 'customerid', ['alias' => 'Booking']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'customer';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Customer[]|Customer|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Customer|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
