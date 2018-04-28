<?php

class Booking extends \Phalcon\Mvc\Model
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
     * @Column(column="bookingdate", type="string", nullable=true)
     */
    public $bookingdate;

    /**
     *
     * @var string
     * @Column(column="starttime", type="string", nullable=true)
     */
    public $starttime;

    /**
     *
     * @var string
     * @Column(column="endtime", type="string", nullable=true)
     */
    public $endtime;

    /**
     *
     * @var integer
     * @Column(column="customerid", type="integer", length=11, nullable=true)
     */
    public $customerid;

    /**
     *
     * @var integer
     * @Column(column="screenid", type="integer", length=11, nullable=true)
     */
    public $screenid;

    /**
     *
     * @var double
     * @Column(column="price", type="double", length=18, nullable=true)
     */
    public $price;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cinema");
        $this->setSource("booking");
        $this->belongsTo('customerid', '\Customer', 'id', ['alias' => 'Customer']);
        $this->belongsTo('screenid', '\Screen', 'id', ['alias' => 'Screen']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'booking';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Booking[]|Booking|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Booking|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
