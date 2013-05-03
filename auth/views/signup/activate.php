<?php
/* @var $this SignupController */
/* @var $model ActivateForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Activate';
$this->breadcrumbs=array(
	'Activate',
);
?>

<h1>Activate</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'activate-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activationCode'); ?>
		<?php echo $form->textField($model,'activationCode'); ?>
		<?php echo $form->error($model,'activationCode'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Activate'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
