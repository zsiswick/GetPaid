</body>
<script src="<?php echo base_url();?>assets/js/vendor/jquery.js"></script>
<script src="<?php echo base_url();?>assets/js/foundation.min.js"></script>
<? if (isset($js_to_load)) : ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/<?=$js_to_load;?>"></script>
<? endif;?>
<script src="<?php echo base_url();?>assets/js/scripts.js"></script>
</html>