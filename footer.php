</div><!-- div #content -->

<footer id="footer">
	<div class="wrapper">

		<div id="top-footer">
			<div class="left-col">
				<p>Plan du site</p>
				<p class="align-left">Accueil</p>
				<p class="align-left">Comment ça marche ?</p>
				<p class="align-left">Faire une simulation</p>
				<p class="align-left">Contact</p>
			</div>

			<div class="middle-col">
				<p>Restez informé sur les bonnes pratiques d’obtenir une meilleure consommation d’eau </p>
				<div class="mailbox">
					<input type="email" name="email" placeholder="Votre adresse mail">
					<input type="submit" value="OK">
				</div>
			</div>

			<div class="right-col">
				<p>Suivez-nous !</p>
				<div class="rs">
					<img src="<?php the_field("logo_facebook", "options") ?>" alt="Logo Facebook">
					<img src="<?php the_field("logo_twitter", "options") ?>" alt="Logo Twitter">
				</div>
			</div>
		</div>

		<div id="bottom-footer">
			<?= ihag_menu('footer'); ?>
			<p>2020 - H2O - Tous droits réservés</p>
		</div>
		
	</div>

</footer>
</div><!-- div #page -->

<?php wp_footer(); ?>

</body>

</html>