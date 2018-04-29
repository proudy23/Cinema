<?php
use Phalcon\Validation;
//use Phalcon\Validation\Validator\Date as DateValidator;
use Phalcon\Validation\Validator\Confirmation as ConfirmationValidator;

class User extends \Phalcon\Mvc\Model

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
     * @Column(column="username", type="string", length=30, nullable=true)
     */
    protected $username;

    /**
     *
     * @var string
     * @Column(column="password", type="string", length=255, nullable=true)
     */
    protected $password;

    /**
     *
     * @var string
     * @Column(column="firstname", type="string", length=30, nullable=true)
     */
    protected $firstname;

    /**
     *
     * @var string
     * @Column(column="surname", type="string", length=30, nullable=true)
     */
    protected $surname;

    /**
     *
     * @var string
     * @Column(column="emailAddress", type="string", length=70, nullable=true)
     */
    protected $emailAddress;

    /**
     *
     * @var string
     * @Column(column="role", type="string", length=30, nullable=true)
     */
    protected $role;

    /**
     *
     * @var string
     * @Column(column="validationkey", type="string", length=255, nullable=true)
     */
    protected $validationkey;

    /**
     *
     * @var string
     * @Column(column="status", type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     *
     * @var string
     * @Column(column="createdat", type="string", nullable=true)
     */
    protected $createdat;

    /**
     *
     * @var string
     * @Column(column="updatedat", type="string", nullable=true)
     */
    protected $updatedat;

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
     * Method to set the value of field username
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
	public function setConfirmPassword($password)
    {
        $this->confirmpassword = $password;

        return $this;
    }

    /**
     * Method to set the value of field firstname
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Method to set the value of field surname
     *
     * @param string $surname
     * @return $this
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Method to set the value of field emailAddress
     *
     * @param string $emailAddress
     * @return $this
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Method to set the value of field role
     *
     * @param string $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Method to set the value of field validationkey
     *
     * @param string $validationkey
     * @return $this
     */
    public function setValidationkey($validationkey)
    {
        $this->validationkey = $validationkey;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Method to set the value of field createdat
     *
     * @param string $createdat
     * @return $this
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Method to set the value of field updatedat
     *
     * @param string $updatedat
     * @return $this
     */
    public function setUpdatedat($updatedat)
    {
        $this->updatedat = $updatedat;

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
     * Returns the value of field username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the value of field firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Returns the value of field surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Returns the value of field emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Returns the value of field role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Returns the value of field validationkey
     *
     * @return string
     */
    public function getValidationkey()
    {
        return $this->validationkey;
    }
	

    /**
     * Returns the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the value of field createdat
     *
     * @return string
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * Returns the value of field updatedat
     *
     * @return string
     */
    public function getUpdatedat()
    {
        return $this->updatedat;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("cinema");
        $this->setSource("user");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
	public function Validation()
	{
	 
		$validator= new Validation();
		//$eValidator=new EmailValidator(["message" => "The email is not valid"]);//
		//$dValidator=new DateValidator(["format" => "Y-m-d","message" =>"the date is invalid"]);
		//$uValidator=new UniquenessValidator(["message" => "This username has already been chosen"]);
		$cValidator=new confirmationValidator(["message" => "password doesnt match confirmation","with" => "confirmpassword"]);
		
		
		//$validator->add('Username', $uvalidator);
		//$validator->add('DateOfBirth', $dvalidator);
		//$validator->add('emailAddress', $evalidator);
		$validator->add('password', $cValidator);
		return $this->validate($validator);
    }


}