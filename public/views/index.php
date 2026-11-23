<?php

// Access the view template engine.
$engine = Backdrop\App::resolve( Backdrop\View\Engine::class );

// Load header/* template.
$engine->display( 'header', Backdrop\Template\Hierarchy\hierarchy() );

// Load content/* template.
$engine->display( 'content', Backdrop\Template\Hierarchy\hierarchy() );

// Load footer/* template.
$engine->display( 'footer', Backdrop\Template\Hierarchy\hierarchy() );
