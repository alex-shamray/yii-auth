<?php

class LogoutController extends Controller
{
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionIndex()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}