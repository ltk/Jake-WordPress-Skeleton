<?php
// Project-Specific

$new_database = array(
    "username" => "username",
    "password" => "password",
    "name" => "wordpress_database",
    "host" => "localhost",
    "prefix" => "wp_"
);

$domains = array(
    "remote" => "dev.example.com.s148974.gridserver.com",
    "local" => "dev.example.com"
);

$wordpress_options = array(
    "title" => "Default Title",
    "allow_search_engines" => 0,
    "url" => "http://dev.example.com"
);

$wordpress_admin_user = array(
    "email" => "info@thejakegroup.com",
    "username" => "wp-admin",
    "password" => "wp-password"
);

// System-Specific
$mysql = array(
    "username" => "root",
    "password" => "root",
    "host" => "localhost"
);

$pages = array(
  array(
    "post_title" => "About Us",
    "child_pages" => array(
      array(
        "post_title" => "Our Staff",
      ),
      array(
        "post_title" => "Our History",
      ),
      array(
        "post_title" => "Our Values",
      )
    )
  ),
  array(
    "post_title" => "Portfolio",
  ),
  array(
    "post_title" => "Services",
  ),
  array(
    "post_title" => "Contact Us",
    "child_pages" => array(
      array(
        "post_title" => "Get in Touch",
        "child_pages" => array(
          array(
            "post_title" => "Online Contact Form",
          ),
          array(
            "post_title" => "Contact Information"
          )
        )
      ),
      array(
        "post_title" => "Careers"
      )
    )
  )
);