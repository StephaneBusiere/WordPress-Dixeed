<?php

/*
Template Name: Minimal Landing Page
*/
?>
<?php get_header(); ?>

<form action="#" method="post" class="form-event">
<p>Aimez vous les ananas?</p>
<div>
  <input type="radio" id="huey" name="drone" value="huey"
         checked>
  <label for="huey">oui</label>
</div>

<div>
  <input type="radio" id="dewey" name="drone" value="dewey">
  <label for="dewey">Non</label>
</div>
<label for="story">Pourquoi aimez vous l'ananas ou non?</label>
<textarea id="story" name="story"
          rows="5" cols="33">

</textarea>
<div class="form-example">
    <input class="suscribeInput" type="submit" value="Dites nous tout!">
  </div>
</form>

  
<?php get_footer(); ?>