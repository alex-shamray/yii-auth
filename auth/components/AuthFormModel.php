<?php

class AuthFormModel extends CFormModel
{
	/**
	 * @var string the ActiveRecord class name.
	 */
	protected $modelClass;
	/**
	 * @var IUser the AR finder instance (eg <code>User::model()</code>).
	 */
	protected $model;

	/**
	 * Initializes this model.
	 * This method is invoked in the constructor right after {@link scenario} is set.
	 * You may override this method to provide code that is needed to initialize the model (e.g. setting
	 * initial property values.)
	 */
	public function init()
	{
		$modelClass=Yii::app()->getController()->getModule()->modelClass;
		if(is_string($modelClass))
		{
			$this->modelClass=$modelClass;
			$this->model=CActiveRecord::model($this->modelClass);
		}
		elseif($modelClass instanceof CActiveRecord)
		{
			$this->modelClass=get_class($modelClass);
			$this->model=$modelClass;
		}

		if(!($this->model instanceof IUser))
			throw new CException(Yii::t('yii','AuthFormModel.modelClass is invalid. Please make sure "{class}" implements IUser interface.',
				array('{class}'=>$this->modelClass)));
		parent::init();
	}
}