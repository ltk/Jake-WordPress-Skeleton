<?php
	global $title;
	if( ! isset( $title ) ){
		$title = $post->post_title;
	}
?>
<div class="subhead">
	<div class="container">
		<h1 class="pull-right h1"><?php echo $title; ?></h1>
	</div>
</div>