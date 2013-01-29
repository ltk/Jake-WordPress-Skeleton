<?php
// Project-Specific

$new_database = array(
    "username" => "xyz-admin",
    "password" => "password1234",
    "name" => "xyz_wordpress",
    "host" => "localhost",
    "prefix" => "wp_"
);

$wordpress_options = array(
    "title" => "Default Title",
    "allow_search_engines" => 0,
    "url" => "http://composertest.com"
);

$wordpress_admin_user = array(
    "email" => "lawson.kurtz@gmail.com",
    "username" => "admin",
    "password" => "this-is-a-password"
);

// System-Specific
$mysql = array(
    "username" => "master",
    "password" => "master",
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