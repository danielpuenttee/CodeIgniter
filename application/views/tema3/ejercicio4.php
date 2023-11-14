<h1>Ejercicio 4</h1>

<?= form_open(); ?>
<div class="form-hidden">
	<?php
		$data = array(
			'type'  => 'hidden',
			'id'    => 'esc1',
			'class' => 'escondidos',
			'value' => $random_number
		);
		echo form_input($data); ?>
</div>
<br>
<br>

<div class="form-input">
	<?= form_label('Campo 1', 'campo1'); ?>
	<?= form_input(array('name' => 'campo1', 'id' => 'input1', 'class' => 'input')); ?>

	<?= form_label('Campo 2', 'campo2'); ?>
	<?= form_input(array('name' => 'campo2', 'id' => 'input2', 'class' => 'input')); ?>
</div>
<br>
<br>

<div class="form-textarea">
	<?= form_label('Campo Textarea', 'textarea_field'); ?>
	<?= form_textarea(array('name' => 'textarea_campo', 'id' => 'txArea1', 'class' => 'textarea')); ?>
</div>
<br>
<br>

<div class="form-dropdown">
	<?= form_label('Dropdown', 'dropdown_field'); ?>
	<?php
		$options = array(
			'option1' => 'Opción 1',
			'option2' => 'Opción 2',
			'option3' => 'Opción 3',
			'option4' => 'Opción 4'
		); ?>
		<?= form_dropdown('dropdown_field', $options, 'option2', 'id="dropdown1" class="seleccionables"'); ?>
</div>
<br>
<br>

<div class="form-checkbox">
	<?= form_label('Checkbox 1', 'checkbox1'); ?>
	<?= form_checkbox('checkbox1', 'checkbox1_value', TRUE, 'id="checkbox1" class="seleccionables"'); ?>
	<br>
	<?= form_label('Checkbox 2', 'checkbox2'); ?>
	<?= form_checkbox('checkbox2', 'checkbox2_value', FALSE, 'id="checkbox2" class="seleccionables"'); ?>
	<br>
	<?= form_label('Checkbox 3', 'checkbox3'); ?>
	<?= form_checkbox('checkbox3', 'checkbox3_value', FALSE, 'id="checkbox3" class="seleccionables"'); ?>
</div>
<br>
<br>

<div class="form-radio">
	<?= form_label('Radio 1', 'radio1'); ?>
	<?= form_radio('radio', 'radio1_value', FALSE, 'id="radio1" class="seleccionables"'); ?>
	<br>
	<?= form_label('Radio 2', 'radio2'); ?>
	<?= form_radio('radio', 'radio2_value', FALSE, 'id="radio2" class="seleccionables"'); ?>
	<br>
	<?= form_label('Radio 3', 'radio3'); ?>
	<?= form_radio('radio', 'radio3_value', FALSE, 'id="radio3" class="seleccionables"'); ?>
</div>
<br>
<br>

<div class="form-submit">
	<?= form_button(array('name' => 'boton_submit', 'id' => 'submit1', 'class' => 'botones', 'content' => 'Aplicar', 'onclick' => "alert('Evento onclick activado')")); ?>
</div>

<?= form_close(); ?>



