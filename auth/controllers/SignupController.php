<?php

class SignupController extends Controller
{
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

				Yii::app()->user->setFlash('signup','Thank you for signing us.');
				$this->refresh();
			}
		}
		// display the signup form
		$this->render('index',array('model'=>$model));
	}

	/**
	 * Displays the activate page
	 */
	public function actionActivate()
	{
		$model=new ActivateForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='activate-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['ActivateForm']) || count($_GET)>=0)
		{
			$model->attributes=isset($_POST['ActivateForm']) ? $_POST['ActivateForm'] : $_GET;
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->activate())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the activate form
		$this->render('activate',array('model'=>$model));
	}
}