<?php

/*
Template Name: Minimal Landing Page
*/
?>
<?php get_header(); ?>

<form action="#" method="post" class="form-event">
<p>Aimez vous les ananas?</p>
<div>
  <input type="radio" id="huey" name="drone" value="oui"
         checked>
  <label for="oui">oui</label>
</div>

<div>
  <input type="radio" id="dewey" name="drone" value="non">
  <label for="oui">Non</label>
</div>
<label for="story">Pourquoi aimez vous l'ananas ou non?</label>
<textarea id="story" name="story"
          rows="5" cols="33">

</textarea>
<div class="form-example">
    <input class="suscribeInput" type="submit" name="envoi"value="Dites nous tout!">
  </div>
</form>
<?php 
if(isset($_POST['envoi'])) 
{
    echo $_POST['story'];
    echo $_POST['drone'];
}
    
?>
<?php
$result=$_POST['drone'];
$text= $_POST['story'];

global $current_user;
var_dump($current_user->ID) ;
$current_user_ID=($current_user->ID);
  global $wpdb;
	
	
	
	$table_name = $wpdb->prefix . 'users';
	
	$wpdb->update( 
		$table_name, 
		array( 'preferences_utilisateur' => $result.'/'.$text, ),
    array ( 'ID'=>$current_user_ID ),
    array ('%s'),
     array( '%s' ) 
        );
?>
<?php
$oagency_settings_options = get_option( 'oagency_settings_option_name' );
$compte = $oagency_settings_options ['compte_twitter_1']; 
echo $compte;
?>  
<?php get_footer(); ?>

