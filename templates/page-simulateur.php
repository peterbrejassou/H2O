<?php
/**
 * Template Name: Page Simulateur
 */

get_header(); 

$questions = get_field("questions");
?>

<section id="simulateur">
    
  <div class="content">
    <p class="big-sentence"><?php the_field('titre_simulateur'); ?></p>

    <?php 
    $index = 1;
    foreach($questions as $q) : ?>
      <div id="simu-question-<?= $index ?>" class="bloc-simulateur<?= $index != 1 ? ' hidden' : '' ?>" data-question="<?= $index ?>">
        <p class="question"><?= $q["question"]; ?></p>
        <p class="consigne"><?php the_field('texte_info'); ?></p>
        <div class="cursor">
          <?php for($i=1; $i<11; $i++): ?>
            <span class="cursor-number"><?= $i ?></span>
          <?php endfor; ?>
        </div>
        <a id="btn-question-<?= $index ?>" class="btn-next"><?php the_field('texte_bouton_simulateur'); ?></a>
      </div>
      
    <?php 
    $index++;
    endforeach; ?>

    <div id="results" class="hidden">
      <div class="resultat">
        <div class="calcul votre-foyer">
          <p>Votre foyer</p>
          <span>850 L</span>
          <p>d'eau par jour</p>
        </div>
        <div class="calcul autres-foyer">
          <p>Autres foyer</p>
          <span>740 L</span>
          <p>d'eau par jour (en moyenne)</p>
        </div>
      </div>
      <div class="more">
        <p>Vous souhaitez réduire votre impact environnemental ainsi que votre facture. H  O vous accompagne quotidiennement dans la gestion de votre consommation. </p>
        <a href="" class="btn-h2o">Oui, je veux en savoir plus</a>
      </div>
    </div>

  </div>
 
</section>

<?php
get_footer();