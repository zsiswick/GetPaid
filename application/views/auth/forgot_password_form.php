<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>
<?php echo form_open($this->uri->uri_string()); ?>
<div class="row">
	<div class="large-6 medium-8 small-centered columns">
		<div class="form-wrap">
			<div class="form-inner-wrap">
				<div class="row">
					<div class="large-12 small-centered columns">
						<?php echo form_label($login_label, $login['id']); ?>
						<?php echo form_input($login); ?>
						<?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
						<hr />
					</div>
				</div>
				<div class="row">
					<div class="large-12 small-centered text-center columns">
						<?php 
							$sdata = array(
							  'name' => 'reset',
							  'class' => 'button round small',
							  'value' => 'Request password',
							  'type' => 'submit',
							  'content' => 'Request password'
							);
							echo form_submit($sdata); 
						?>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>