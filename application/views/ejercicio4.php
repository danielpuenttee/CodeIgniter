<!--<h1>Ejercicio 4</h1>-->
<!---->
<!---->

<!--//$parametros = array('class' => 'miClase', 'id' => 'form1', 'name' => 'Mi formulario', 'method' => 'get');-->
<!--//-->
<!--//echo form_open('myUrl.com', $parametros);-->
<!--//-->
<!--//$data = array(-->
<!--//	'type'  => 'hidden',-->
<!--//	'id'    => 'esc1',-->
<!--//	'class' => 'escondidos',-->
<!--//	'value' => random_int(0, 999)-->
<!--//);-->
<!--//echo form_input($data);;-->
<!--//-->
<!--//$data = array(-->
<!--//	'id'    => 'input1',-->
<!--//	'value' => '',-->
<!--//	'class' => 'input'-->
<!--//);-->
<!--//echo form_input($data) . '<br><br>';-->
<!--//-->
<!--//$data = array(-->
<!--//	'id'    => 'input2',-->
<!--//	'value' => '',-->
<!--//	'class' => 'input'-->
<!--//);-->
<!--//echo form_input($data) . '<br><br>';-->
<!--//-->
<!--//-->
<!--//echo form_textarea()-->
<!--//-->
<!--//echo form_close();-->

<!DOCTYPE html>
<html>
<body>
    <h1>Ejercicio 4</h1>
    <?php echo form_open(); ?>

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
        <?php echo form_label('Campo 1', 'campo1'); ?>
        <?php echo form_input(array('name' => 'campo1', 'id' => 'input1', 'class' => 'input')); ?>

        <?php echo form_label('Campo 2', 'campo2'); ?>
        <?php echo form_input(array('name' => 'campo2', 'id' => 'input2', 'class' => 'input')); ?>
    </div>
	<br>
	<br>

    <div class="form-textarea">
        <?php echo form_label('Campo Textarea', 'textarea_field'); ?>
        <?php echo form_textarea(array('name' => 'textarea_campo', 'id' => 'txArea1', 'class' => 'textarea')); ?>
    </div>
	<br>
	<br>

    <div class="form-dropdown">
        <?php echo form_label('Dropdown', 'dropdown_field'); ?>
        <?php
            $options = array(
                'option1' => 'Opción 1',
                'option2' => 'Opción 2',
                'option3' => 'Opción 3',
                'option4' => 'Opción 4'
            );
            echo form_dropdown('dropdown_field', $options, 'option2', 'id="dropdown1" class="seleccionables"');
        ?>
    </div>
	<br>
	<br>

    <div class="form-checkbox">
        <?php echo form_label('Checkbox 1', 'checkbox1'); ?>
        <?php echo form_checkbox('checkbox1', 'checkbox1_value', TRUE, 'id="checkbox1" class="seleccionables"'); ?>
		<br>
        <?php echo form_label('Checkbox 2', 'checkbox2'); ?>
        <?php echo form_checkbox('checkbox2', 'checkbox2_value', FALSE, 'id="checkbox2" class="seleccionables"'); ?>
		<br>
        <?php echo form_label('Checkbox 3', 'checkbox3'); ?>
        <?php echo form_checkbox('checkbox3', 'checkbox3_value', FALSE, 'id="checkbox3" class="seleccionables"'); ?>
    </div>
	<br>
	<br>

    <div class="form-radio">
        <?php echo form_label('Radio 1', 'radio1'); ?>
        <?php echo form_radio('radio', 'radio1_value', FALSE, 'id="radio1" class="seleccionables"'); ?>
		<br>
        <?php echo form_label('Radio 2', 'radio2'); ?>
        <?php echo form_radio('radio', 'radio2_value', FALSE, 'id="radio2" class="seleccionables"'); ?>
		<br>
        <?php echo form_label('Radio 3', 'radio3'); ?>
        <?php echo form_radio('radio', 'radio3_value', FALSE, 'id="radio3" class="seleccionables"'); ?>
    </div>
	<br>
	<br>

    <div class="form-submit">
        <?php echo form_button(array('name' => 'boton_submit', 'id' => 'submit1', 'class' => 'botones', 'content' => 'Aplicar', 'onclick' => "alert('Evento onclick activado')")); ?>
    </div>

    <?php echo form_close(); ?>
</body>
</html>


