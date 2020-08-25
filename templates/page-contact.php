<?php
/**
 * Template Name: Page Contact
 */

get_header(); 
?>

<section id="contact">
  
  <div class="content">
    <div class="question">
      <p class="contact-title"><?= get_field('haut_de_page')['titre'] ?><br><span><?= get_field('haut_de_page')['sous_titre'] ?></span></p>
      <a href="<?= get_field('haut_de_page')['lien_bouton'] ?>" class="btn-h2o"><?= get_field('haut_de_page')['texte_bouton'] ?></a>
    </div>

    <p class="ou">ou</p>

    <div class="form">
      <p><?= the_field('titre_forumaire') ?></p>
      
      <div class="form-content">
        <label for="name">Nom</label>
        <input type="text" name="name" id="name">
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname">
        <label for="mail">Adresse mail</label>
        <input type="email" name="mail" id="mail">
        <label for="city">Ville</label>
        <input type="text" name="city" id="city">

        <div class="radio-div">
          <span>Qui êtes-vous ?</span>
          <div class="choices">
            <div class="radio-choice">
              <label for="particulier">Particulier</label>
              <input type="radio" id="particulier" name="type" value="particulier" class="radio-btn">
            </div>
            <div class="radio-choice">
              <label for="particulier">Particulier</label>
              <input type="radio" id="particulier" name="type" value="particulier" class="radio-btn">
            </div>
            <div class="radio-choice">
              <label for="particulier">Particulier</label>
              <input type="radio" id="particulier" name="type" value="particulier" class="radio-btn">
            </div>
          </div>
        </div>

        <label for="message">Votre message</label>
        <textarea name="message" id="message" cols="30" rows="10"></textarea>

        <input type="submit" value="Envoyer">

      </div>
    </div>
  </div>
  
</section>

<?php
get_footer();