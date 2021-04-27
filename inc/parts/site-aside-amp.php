<?php
/**
 * Site aside template part for Eksell.
 *
 * @package eksell
 */

?>
<aside id="site-aside">

	<?php
	do_action( 'eksell_site_aside_start' );
	?>

	<a on="tap:AMP.setState({visible: !visible})" href="#" class="toggle nav-toggle has-bars" [class]="'toggle nav-toggle has-bars' + (visible ? ' active' : '')"  data-toggle-target=".menu-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-menu-modal" aria-pressed="false" [aria-pressed]="visible ? 'true' : 'false'" role="button" data-set-focus=".menu-modal .main-menu &gt; li:first-child a">
		<div class="nav-toggle-inner">
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'eksell' ); ?></span>
			<div class="bars">
				<div class="bar"></div>
				<div class="bar"></div>
				<div class="bar"></div>
			</div><!-- .bars -->
		</div><!-- .nav-toggle-inner -->
	</a><!-- .nav-toggle -->

	<?php
	do_action( 'eksell_site_aside_end' );
	?>

</aside><!-- #site-aside -->
