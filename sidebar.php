<?php
$context = array();
$context['right'] = Timber::get_widgets('right');
Timber::render('sidebar.twig', $context);
               
