<?php
/**
 * Template Name: Homepage
 */

get_header(); 
?> 

<section id="home">

  <div class="solution">
    <div class="content">
      <div class="logo-title">
        <img src="<?= get_field("solution")["icone_ampoule"]; ?>" alt="Logo Solution">
        <span class="h2-style"><?= get_field("solution")["h1_home"]; ?></span>
        <img src="<?= get_field("solution")["icone_robinet"]; ?>" alt="Logo Robinet">
      </div>

      <span class="baseline"><?= get_field("solution")["citation"]; ?></span>
    
      <p>H2O est une start-up qui vise à offrir à la population, des capteurs reliés à une application permettant de vous informer sur la quantité d’eau que vous consommer chaque jour. Cette solution a pour objectif de vous faire réagir et agir sur votre consommation d’eau directement, en vous donnant conscience de la quantité d’eau que vous pouvez utiliser au quotidien. Ainsi, pour vous aider dans cette prise de conscience, nous avons créé une application qui vous permet de visualiser l’équivalence en eau dépensée comme par exemple.</p>
      <p class="big-blue">“ Aujourd’hui, vous avez écoulé l’équivalent de 5 baignoirs ! ”</p>
      <p>
      Pour aller plus loin, H2O vous offrira de bons conseils pour vous aider à réguler votre consommation d’eau et transmettre les bonnes pratiques à votre famille ou à votre entreprise. Les capteurs seront uniquement des outils pour mesurer votre consommation quotidienne, que vous pourrez installer à vos robinets de manière simple et efficace.  
      </p>

      <div class="bottom-number">
        <p class="number"><?= get_field("solution")["chiffre"]; ?></p>
        <p><span class="blue">d’économie d’eau</span> possible par foyer sans perte de confort</p>
      </div>
      
    </div>
  </div>

  <div class="regulation">
    <div class="content">
      <div class="logo-title">
        <img src="<?= get_field("outils")["icone_profil"]; ?>" alt="Logo Regulation">
        <span class="h2-style"><?= get_field("outils")["h2_titre"]; ?></span>
      </div>

      <div class="content-regulation">
        <div class="first">
          <img src="<?= get_field("outils")["mockup_appli"]; ?>" alt="">
          <a href="#" class="btn-h2o"><?= get_field("outils")["bouton_appli"]; ?></a>
        </div>
        <p>+</p>
        <div class="second">
          <img src="<?= get_field("outils")["capteur"]; ?>" alt="">
          <a href="#" class="btn-h2o"><?= get_field("outils")["bouton_capteur"]; ?></a>
        </div>
      </div>
    </div>
  </div>

  <div class="economies">
    <div class="content">
      <div class="logo-title">
        <img src="<?= get_field("impact_ecologique")["icone_camion"]; ?>" alt="Logo Economies">
        <span class="h2-style"><?= get_field("impact_ecologique")["h2_titre"]; ?></span>
      </div>

      <p class="intro-text"><?= get_field("impact_ecologique")["contenu"]; ?></p>

      <div class="content-economies">
        <div class="part">
          <img src="<?= get_field("impact_ecologique")["icone_terre"]; ?>" alt="Logo Couper l'eau">
          <p>Économisez plus de 
            <br><span class="big-blue">20 000 L</span> à l’année* 
            <br><span class="little">(*pour un foyer de 3 personnes)</span></p>
        </div>
        <div class="part">
          <img src="<?= get_field("impact_ecologique")["icone_economy"]; ?>" alt="Logo Économies">
          <p>Réduction de la facture 
            <br><span class="big-blue">par 2</span></p>
        </div>
      </div>
    </div>
  </div>

  <div class="agir">
    <div class="content">
      <div class="logo-title">
        <img src="<?= get_field("agir_a_son_niveau")["icone_discussion"]; ?>" alt="Logo Agir">
        <span class="h2-style"><?= get_field("agir_a_son_niveau")["h2_titre"]; ?></span>
      </div>

      <div class="content-agir">
        <div class="part">
          <img src="<?= get_field("agir_a_son_niveau")["icone_eau"]; ?>" alt="Logo Eau">
          <p><?= get_field("agir_a_son_niveau")["intitule_eau"]; ?></p>
        </div>
        <div class="part">
          <img src="<?= get_field("agir_a_son_niveau")["icone_plante"]; ?>" alt="Logo Plante">
          <p><?= get_field("agir_a_son_niveau")["intitule_plante"]; ?></p>
        </div>
        <div class="part">
          <img src="<?= get_field("agir_a_son_niveau")["icone_earth"]; ?>" alt="Logo Terre">
          <p><?= get_field("agir_a_son_niveau")["intitule_earth"]; ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="simulation">
    <div class="content">
      <div class="logo-title">
        <img src="<?= get_field("simulation")["icone_simulation"]; ?>" alt="Logo Simulation">
        <span class="h2-style"><?= get_field("simulation")["h2_titre"]; ?></span>
      </div>

      <p>Vous aimeriez connaître la quantité d’eau que vous consommez à l’année ? 
        <br>Il n’y a rien de plus simple que de répondre à quelques questions qui resteront entre vous et moi. Promis !
        <br>
        <br>
        Je vous invite à tester dès maintenant votre consommation d’eau. 
      </p>

      <a href="<?= get_field("simulation")["lien_simulation"]; ?>" class="btn-h2o"><?= get_field("simulation")["bouton_simulation"]; ?></a>
    </div>
  </div>

  <div class="partenaires">
    <div class="content">
      <div class="logo-title">
        <img src="<?= get_field("partenaires")["icone_partners"]; ?>" alt="Logo Partnaires">
        <span class="h2-style"><?= get_field("partenaires")["h2_titre"]; ?></span>
      </div>
      <?php if ( get_field("partenaires")["logos_partners"] ) : ?>
        <div class="partenaires-logos">
          <?php foreach( get_field("partenaires")["logos_partners"] as $logo ) : ?>
            <img src="<?= $logo["logo_partenaire"] ?>" alt="<?= $logo["texte_logo"] ?>">
          <?php endforeach; ?>
        </div>
      <?php endif; ?>      
    </div>
  </div>
 
</section>

<?php
get_footer();