<?php
/**
 * Block Name: Bloc Info
 */
 ?>
 <section class="blocs-info inner-width-medium">
  <?php
  $blocs_info = get_field('blocs_info');
  if ( !$blocs_info ) :
    ?>
    <em>Renseigner les blocs info...</em>
    <?php
  else :
    foreach ($blocs_info as $key => $bloc_info) :
      ?>
      <div class="bloc-info <?php echo $bloc_info["size"]; ?> <?php echo $bloc_info["style"]; ?>">
        <h2 class="title"></span><?php echo $bloc_info["title"]; ?></h2>
        <hr>
        <?php echo $bloc_info["description"]; ?>
    </div>
      <?php
    endforeach;
  endif;
  ?>
</section>
