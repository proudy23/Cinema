<?php

class Movie extends \Phalcon\Mvc\Model
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
     * @Column(column="movietitle", type="string", length=40, nullable=true)
     */
    public $movietitle;

    /**
     *
     * @var string
     * @Column(column="movieyear", type="string", nullable=true)
     */
    public $movieyear;

    /**
     *
     * @var string
     * @Column(column="genre", type="string", length=15, nullable=true)
     */
    public $genre;

    /**
     *
     * @var string
     * @Column(column="Actors", type="string", length=20, nullable=true)
     */
    public $actors;

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
        $this->setSource("movie");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'movie';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Movie[]|Movie|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Movie|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
