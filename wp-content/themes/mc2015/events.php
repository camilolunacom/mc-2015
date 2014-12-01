<?php 
	$idioma = kcMultilingual_backend::$lang;
	if( $idioma == 'fr' ){
		$field_id = 'events-editor-fr';
	}else{
		$field_id = 'events-editor';
	}

	$contenido = kc_get_option( 'mcg', 'gallery', $field_id );
?>

<div class="events">
	<?php echo $contenido ?>
</div>