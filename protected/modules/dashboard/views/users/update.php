<?php $htmlOptions = array('class' => 'pure-input-2-3'); ?>
<?php $form = $this->beginWidget('cii.widgets.CiiActiveForm', array(
	'enableAjaxValidation'=>true,
    'htmlOptions' => array(
    	'class' => 'pure-form pure-form-aligned'
    )
)); ?>
<div class="header">
	<div class="pull-left">
		<h3>Change User Information</h3>
		<p>Change information for <?php echo $model->name; ?></p>
	</div>
	<div class="pull-right">
		<?php echo CHtml::submitButton('Save Changes', array('id' => 'header-button', 'class' => 'pure-button pure-button-primary pure-button-small pull-right')); ?>
	</div>
	<div class="clearfix"></div>
</div>
<div id="main" class="nano">
	<div class="content">
		<fieldset>
				<legend>System Information</legend>
				<div class="pure-control-group">
					<?php echo $form->toggleButtonRow($model, 'status', $htmlOptions); ?>
				</div>
				<div class="pure-control-group">
					<?php echo $form->emailFieldRow($model, 'email', $htmlOptions); ?>
				</div>
				<div class="pure-control-group">
					<?php echo $form->textFieldRow($model, 'displayName', $htmlOptions); ?>
				</div>
				<div class="pure-control-group">
					<?php echo $form->dropDownListrow($model, 'user_role', CHtml::listData(UserRoles::model()->findAll(), 'id', 'name'), $htmlOptions); ?>
				</div>

				<legend>Optional Information</legend>
				<div class="pure-control-group">
					<?php echo $form->textFieldRow($model, 'firstName', $htmlOptions); ?>
				</div>
				<div class="pure-control-group">
					<?php echo $form->textFieldRow($model, 'lastName', $htmlOptions); ?>
				</div>
				<div class="pure-control-group">					
					<?php echo $form->textAreaRow($model, 'about', array('class' => 'pure-input-2-3', 'style' => 'height: 300px')); ?>
				</div>

				<legend>Password</legend>
				<div class="pure-control-group">
					<?php echo $form->passwordFieldRow($model, 'password', array('class' => 'pure-input-2-3', 'placeholder' => 'Set or change a user\'s password. Otherwise leave blank')); ?>
				</div>
				<legend>Metadata
					<span class="meta-icon-plus pull-right icon-plus pure-button pure-button-link"></span>
				</legend>
				<div class="meta-container">
					<?php foreach ($model->metadata as $meta): ?>
						<?php $options = array('class' => 'pure-input-2-3', 'type' => 'text', 'value' => $meta->value, 'name' => 'UserMetadata[' . $meta->key . ']'); ?>

						<div class="pure-control-group">
							<?php echo CHtml::tag('label', array(), Cii::titleize($meta->key)); ?>
							<?php if (strpos($meta->key, 'Provider') !== false): ?>
								<?php $options['disabled'] = true; ?>
							<?php elseif ($meta->key == 'likes'): ?>
								<?php $options['disabled'] = true; ?>
								<?php $options['value'] = count(json_decode($meta->value, true)); ?>
							<?php endif; ?>
							<?php echo CHtml::tag('input', $options, NULL); ?>
						</div>
					<?php endforeach; ?>
				</div>

			<?php echo CHtml::submitButton('Save Changes', array('class' => 'pure-button pure-button-primary pure-button-small pull-right')); ?>
		<fieldset>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php $asset=Yii::app()->assetManager->publish(YiiBase::getPathOfAlias('application.modules.dashboard.assets'), true, -1, YII_DEBUG); ?>
<?php $cs = Yii::app()->getClientScript(); ?>
<?php $cs->registerScriptFile($asset.'/js/jquery.nanoscroller.min.js', CClientScript::POS_END); ?>
<?php $cs->registerScript('nano-scroller', '
		$("#main.nano").nanoScroller();
'); ?>
<?php $cs->registerScript('add-meta', '
	$(".meta-icon-plus").click(function(e) {
		$(".meta-container").append("<div class=\"pure-control-group\"><label contenteditable=true>Click to Change</label><input type=\"text\" class=\"pure-input-2-3\" value=\"\" /></div>");

		$(".meta-container input").on("keyup change", function() {
			$(this).attr("name", "UserMetadata[" + $(this).prev().text() + "__new]");
		})

	});

	setInterval(function() {
		$(".meta-container label[contenteditable]").each(function() {
			$(this).next().attr("name", "UserMetadata[" + $(this).text() + "__new]");
		});
	}, 1000)
'); ?>