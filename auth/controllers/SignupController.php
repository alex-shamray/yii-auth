<?php

class SignupController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow guest users to perform any action
				'users'=>array('?'),
			),
			array('deny',  // deny authenticated users
				'users'=>array('@'),
			),
		);
	}

	/**
	 * Displays the signup page
	 */
	public function actionIndex()
	{
		$model=new SignupForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='signup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['SignupForm']))
		{
			$model->attributes=$_POST['SignupForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->signup())
			{
				$message=new YiiMailMessage;
				$message->view='signup';
				$message->setBody(array('model'=>$model),'text/html');
				$message->subject='Sign Up';
				$message->addTo($model->email);
				$message->from=Yii::app()->params['adminEmail'];
				Yii::app()->mail->send($message);

				Yii::app()->user->setFlash('signup','Thank you for signing up.');
				$this->refresh();
			}
		}
		// display the signup form
		$this->render('index',array('model'=>$model));
	}

	/**
	 * Activates a user.
	 * @param integer $id the ID of the user to be activated
	 * @param string $key the activation key
	 */
	public function actionActivate($id,$key)
	{
		$model=$this->loadModel($id,$key);
		$model->activate();
		$model->login();

		$this->redirect($model->getProfileUrl());
	}

	/**
	 * Displays the resend page
	 */
	public function actionResend()
	{
		$model=new ResendForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='resend-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['ResendForm']))
		{
			$model->attributes=$_POST['ResendForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->resend())
			{
				$message=new YiiMailMessage;
				$message->view='signup';
				$message->setBody(array('model'=>$model),'text/html');
				$message->subject='Sign Up';
				$message->addTo($model->user->email);
				$message->from=Yii::app()->params['adminEmail'];
				Yii::app()->mail->send($message);

				Yii::app()->user->setFlash('resend','Thank you for resending activation code.');
				$this->refresh();
			}
		}
		// display the resend form
		$this->render('resend',array('model'=>$model));
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