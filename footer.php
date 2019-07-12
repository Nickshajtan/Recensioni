<?php
$context = array();
$context['footer'] = Timber::get_widgets('footer');
Timber::render('footer.twig', $context);
               
