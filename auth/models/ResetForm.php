<?php

/**
 * ResetForm class.
 * ResetForm is the data structure for keeping
 * user reset form data. It is used by the 'reset' action of 'RecoverController'.
 */
class ResetForm extends AuthFormModel
{
	public $password;
	public $password_repeat;

	private $_user;

	/**
	 * Constructor.
	 * @param IUser $user the model instance
	 */
	public function __construct($user)
	{
		parent::__construct();
		$this->_user=$user;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password, password_repeat', 'required'),
			array('password', 'compare'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'password' => 'Password',
			'password_repeat' => 'Password Repeat',
		);
	}

	/**
	 * Resets the user's password using the given password in the model.
	 * @return boolean whether reset is successful
	 */
	public function reset()
	{
		$this->_user->changePassword($this->password);

		$identity=new UserIdentity($this->model,$this->_user->username,$this->password);
		$identity->authenticate();

		if($identity->errorCode===UserIdentity::ERROR_NONE)
		{
			Yii::app()->user->login($identity);
			return true;
		}
		else
			return false;
	}
}
