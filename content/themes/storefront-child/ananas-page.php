<?php

/*
Template Name: Ananas choise Page
*/
?>
<?php get_header(); ?>

<form action="#" method="post" class="form-event">
    <p>Aimez vous les ananas?</p>
    <div>
    <input type="radio" id="huey" name="drone" value="oui"checked>
    <label for="oui">oui</label>
    </div>
    <div>
    <input type="radio" id="dewey" name="drone" value="non">
    <label for="oui">Non</label>
    </div>
    <label for="story">Pourquoi aimez vous l'ananas ou non?</label>
    <textarea id="story" name="story"rows="5" cols="33"></textarea>
    <div class="form-example">
    <input class="suscribeAnanas" type="submit" name="envoi"value="Dites nous tout!">
    </div>
</form>



<?php 
    $choiseresult='';
    $choisetext='';
if(isset($_POST['envoi'])) 
{
    $choiseresult=$_POST['drone'];
    $choisetext= $_POST['story'];  
}   
if 
    ($choiseresult=='oui')
{
    $text='vous aimez les ananas parceque';
}
else $text='vous n\'aimez pas les ananas parceque';
?>
<?php
if(isset($_POST['envoi'])) {
  echo  '<p class="choiseText" >Merci! Nous avons bien compris que'.
  " ".$choiseresult.","."  ".$text." ".$choisetext ;
}


global $current_user;

$current_user_ID=($current_user->ID);
  global $wpdb;
	
	
	
	$table_name = $wpdb->prefix . 'users';
	
	$wpdb->update( 
		$table_name, 
		array( 'preferences_utilisateur' => $choiseresult.", ".$choisetext, ),
    array ( 'ID'=>$current_user_ID ),
    array ('%s'),
     array( '%s' ) 
        );
?>

<?php get_footer(); ?>

