<?php

class Screen extends \Phalcon\Mvc\Model
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
     * @Column(column="area", type="string", length=30, nullable=true)
     */
    public $area;

    /**
     *
     * @var integer
     * @Column(column="floor", type="integer", length=1, nullable=true)
     */
    public $floor;

    /**
     *
     * @var integer
     * @Column(column="recliner", type="integer", length=1, nullable=true)
     */
    public $recliner;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cinema");
        $this->setSource("screen");
        $this->hasMany('id', 'Booking', 'screenid', ['alias' => 'Booking']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'screen';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Screen[]|Screen|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Screen|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
