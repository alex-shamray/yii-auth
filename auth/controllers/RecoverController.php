<?php

class RecoverController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the recover page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * Displays the recover page
	 */
	public function actionIndex()
	{
		$model=new RecoverForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='recover-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['RecoverForm']))
		{
			$model->attributes=$_POST['RecoverForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->recover())
			{
				$message=new YiiMailMessage;
				$message->view='recover';
				$message->setBody(array('model'=>$model),'text/html');
				$message->subject='Recover';
				$message->addTo($model->user->email);
				$message->from=Yii::app()->params['adminEmail'];
				Yii::app()->mail->send($message);

				Yii::app()->user->setFlash('recover','Thank you for password recovery.');
				$this->refresh();
			}
		}
		// display the recover form
		$this->render('index',array('model'=>$model));
	}

	/**
	 * Displays the reset page
	 * @param integer $id the ID of the user
	 * @param string $key the activation key
	 */
	public function actionReset($id,$key)
	{
		$model=new ResetForm($this->loadModel($id,$key));

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='reset-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['ResetForm']))
		{
			$model->attributes=$_POST['ResetForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->reset())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the reset form
		$this->render('reset',array('model'=>$model));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @param string $key the activation key
	 * @return IUser the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id,$key)
	{
		$model=ActiveRecord::model($this->module->modelClass)->findByPk($id);
		if($model===null || !$model->validateActivationKey($key))
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}