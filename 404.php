<?php
$context = Timber::get_context();
$context['options'] = get_fields('options');
$context['sidebar'] = Timber::get_sidebar('sidebar.php');
$context['footer'] = Timber::get_sidebar('footer.php');
Timber::render( '404.twig', $context ); 