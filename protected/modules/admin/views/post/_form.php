<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'id'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'outline'); ?>
		<?php echo $form->textArea($model,'outline',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'outline'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'thumbnail'); ?>
		<?php echo $form->fileField($model,'thumbnail'); ?>
		<?php echo $form->error($model,'thumbnail'); ?>
	</div>

	<div class="row">
    <label>ImageURL:</label> 
    <?php echo $form->dropDownList($model,'id',CHtml::listData(Images::model()->findAllByAttributes(array('post_id'=>$model->id)), 'id', 'file')); ?>
    <?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/images/upload/'.$model->id.'_'?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file'); ?>
        <?php $this->widget('application.extensions.tinymce.ETinyMce', 
            array(
                'model'=>$model,
                'attribute'=>'file',
                'editorTemplate'=>'full',
                'htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'tinymce'),
            ));?>
		<?php //echo $form->textField($model,'file',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'file'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'publish'); ?>
		<?php echo $form->dropDownList($model,'publish',array(0=>'FALSE',1=>'TRUE')); ?>
		<?php echo $form->error($model,'publish'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
