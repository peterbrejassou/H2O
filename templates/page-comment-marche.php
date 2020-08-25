<?php
/**
 * Template Name: Page Comment ça marche
 */

get_header(); 
?>

<section id="comment-marche">
    
    <div class="header-title">
      <div class="content">
        <h1><?= get_field('header_comment_marche')['titre'] ?></h1>
        <p><?= get_field('header_comment_marche')['description'] ?></p>
      </div>
    </div>

    <?php if ( have_rows('etapes') ) : ?>
      <div class="etapes">
        <div class="content">
          <p class="intro-texte"><?php the_field('titre_section_etapes'); ?></p>
          <?php while( have_rows('etapes') ) : the_row(); ?>
            <div class="step">
              <span class=number><?php the_sub_field('numero'); ?></span>
              <div class="textes">
                <p class="titre"><?php the_sub_field('titre'); ?></p>
                <p class="description"><?php the_sub_field('description'); ?></p>
              </div>
            </div>      
          <?php endwhile; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="congrats">
      <div class="content">
        <img src="<?= get_field('fin_etapes')['logo'] ?>" alt="<?= get_field('fin_etapes')['logo_alt'] ?>">
        <span class="h2-style"><?= get_field('fin_etapes')['titre'] ?></span>
        <a href="#open-modal" class="btn-h2o"><?= get_field('fin_etapes')['bouton'] ?></a>

        <div id="open-modal" class="modal-window">
          <div>
            <a href="#" title="Close" class="modal-close">Fermer</a>
            <iframe width="949" height="534" src="https://www.youtube.com/embed/hFtn-7pjf1Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
      </div>
    </div>

    <div class="technologie">
      <div class="content">
        <p class="h2-style"><?= get_field('technologie_capteurs')['titre'] ?></p>
        <div class="content-tech">
          <p class="parag-texte"><?= get_field('technologie_capteurs')['description'] ?></p>
          <?= wp_get_attachment_image(get_field('technologie_capteurs')['image'], "292x363"); ?>
        </div>
      </div>
    </div>

    <div class="application">
      <div class="content">
        <p class="h2-style"><?= get_field('application')['titre'] ?></p>
        <div class="content-app">
          <?php if ( $gp_images = get_field('application')['groupe_dimages'] ) : ?>
            <div class="logos">
              <?php foreach( $gp_images as $img) : ?>
                <img src="<?= $img['image'] ?>" alt="<?= $img['image_alt'] ?>">
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <p class="parag-texte"><?= get_field('application')['description'] ?></p>
        </div>
      </div>
    </div>

    <div class="distributeurs">
      <div class="content">
        <p class="h2-style"><?= get_field('distributeurs')['titre'] ?></p>

        <?php if ( $distributeurs = get_field('distributeurs')['image'] ) : ?>
          <div class="distributeurs-logos">
            <?php foreach( $distributeurs as $distrib) : ?>
              <img src="<?= $distrib['image'] ?>" alt="<?= $distrib['image_alt'] ?>">
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>

    <div class="questions">
      <div class="content">
        <p class="h2-style"><?= get_field('footer_comment_marche')['titre'] ?></p>
        <a href="<?= get_field('footer_comment_marche')['lien_bouton'] ?>" class="btn-h2o"><?= get_field('footer_comment_marche')['bouton'] ?></a>
        <div class="footer-questions"><?= get_field('footer_comment_marche')['description'] ?></div>
      </div>
    </div>
 
</section>

<?php
get_footer();