<?php 
$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
$args = array(
    showposts => 3
);
$context['posts'] = Timber::get_posts($args);
$context['options'] = get_fields('options');
$context['sidebar'] = Timber::get_sidebar('sidebar.php');
$context['footer'] = Timber::get_sidebar('footer.php');
Timber::render( 'single.twig', $context ); 