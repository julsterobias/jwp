<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0" />
<title><?php
    global $page, $paged;
    wp_title( '|', true, 'right' );
    bloginfo( 'name' );
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        echo " | $site_description";
    if ( $paged >= 2 || $page >= 2 )
        echo ' | ' . sprintf( __( 'Page %s', 'jwp' ), max( $paged, $page ) );
    ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/style.css">

<meta name="keywords" content="jwptemplate, jwp, WordPress, scaffolding template, basic, WordPress template, basic">
<meta name="description" content="jwptemplate is a basic scaffolding template ideal for every customize designed wordpress websites.
It provides simple UI for most common wordpress hooks and actions.">
<?php wp_head(); ?>
</head>

<body <?php body_class($post->ID); ?>>

<header>
    <span></span>
    <div class="container">
        <nav>
            <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
        </nav>

        <div class="jwp_title">
            <?php if(!is_archive()): ?>
            <?php if(is_home()): ?>
            <h1><?php bloginfo('name') ?></h1>
            <h2><?php bloginfo('description') ?></h2>
            <?php else: ?>
            <h2><?php the_title(); ?></h2>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</header>