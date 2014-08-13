	</section>
<footer>
	<div class="row">
		<div class="small-6 small-centered columns text-center">
		
			<p>&#169; <?php echo(date('Y'))?>, Ruby Invoice</p>
			<p>Made by <a href="http://www.chromaloop.com">Chromaloop</a></p>
		</div>
	</div>
</footer>	
</body>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/foundation.min.js"></script>
<? if (isset($js_to_load)) : 
		foreach ($js_to_load as $js) : ?>
			<script type="text/javascript" src="<?php echo base_url();?>assets/js/<?=$js;?>"></script>
<?php endforeach;?>
	
<? endif;?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js"></script>
</html>