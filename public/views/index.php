<?php

// Access the view template engine.
$engine = Backdrop\App::resolve( 'view/engine' );

// Load header/* template.
$engine->display( 'header', Backdrop\Template\hierarchy() );

// Load content/* template.
$engine->display( 'content', Backdrop\Template\hierarchy() );

// Load footer/* template.
$engine->display( 'footer', Backdrop\Template\hierarchy() );
