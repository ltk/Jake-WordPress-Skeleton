<?php
/*
Template Name: Page w/ FAQs
*/
global $show_faqs;
$show_faqs = true;
get_template_part('page');
?>
<script type="text/javascript">
$(function(){
    $('.question').click(function(e) {
        $(this).siblings(".answer").slideToggle('normal', function() {
            $(this).addClass('showing');
        });
    });
});
</script>

