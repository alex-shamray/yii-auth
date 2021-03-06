<?php

class AuthModule extends CWebModule
{
	/**
	 * @var string the IUser class name.
	 */
	public $modelClass='User';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'auth.models.*',
			'auth.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	/**
	 * @param string $path the root directory of view files.
	 * @throws CException if the directory does not exist.
	 */
	public function setViewPath($path)
	{
		parent::setViewPath(Yii::getPathOfAlias($path));
	}
}
