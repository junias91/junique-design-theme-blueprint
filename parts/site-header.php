<?php 


?>
<header id="site-header" class="site-header" data-theme="primary">
	<div class="container">

		<div class="brand-wrapper">
      <?php logo(); ?>			
			<button class="btn btn-accent nav-open" data-toggle-target="navigation" data-toggle-class="active" data-toggle-scroll-lock>
				<?php _e('Menü', 'blueprint'); ?>
				<div class="menu-burger" data-toggle-name="navigation" data-toggle-class="active">
					<span></span>
					<span></span>					
				</div><!-- #menu-burger -->
			</button><!-- nav-open -->
		</div><!-- brand-wrapper -->
		
		<div class="side-wrapper">
			<?php site_header_asside(); ?>
		</div><!-- side-wrapper -->		

		<div class="nav-wrapper" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" data-toggle-name="navigation" data-toggle-class="active">
			<?php main_menu(); ?>		
		</div><!-- nav-wrapper -->	

	</div><!-- container -->
</header><!-- site-header -->

<?php junique_custom_menu(); ?>