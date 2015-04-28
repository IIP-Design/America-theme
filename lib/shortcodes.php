<?php

function america_responsive_iframe( $atts, $content = null ) {
  extract(shortcode_atts(array(
      'allowfullscreen' => 1,
      'chat' => 0,
      'iframe_class' => '',
      'ratio' => '16-9',
      'frameborder' => 0,
      'height' => 315,
      'width' => 560,
  ), $atts));

   $container_classes = '';

   if ( $chat == 1 ) {
     $container_classes .= ' chat';
   } else {
     $container_classes .= '';
   }

   if ( $ratio == '4-3' ) {
     $container_classes .= ' ratio-4-3';
   } else {
     $container_classes .= ' ratio-16-9';
   }

   $markup = '<div class="media-container' . $container_classes . '">' ;

   $markup .= '<iframe class="' . $iframe_class . '" src="' . $content . '" width="' . $width . '" height="' . $height . '" frameborder="' . $frameborder . '" allowfullscreen="' . $allowfullscreen . '" ></iframe>';

   $markup .= '</div>';

   return $markup;
}


function america_takeaway( $atts, $content = null ) {
  extract(shortcode_atts(array(
    'title' => 'Key Takeways',
    'align' => 'alignleft',
  ), $atts));

  $markup = '<div class="takeaway '.$align.'">';
    $markup .= '<h3 class="takeaway-title">'.$title.'</h3>';
    $markup .= '<ul>'.$content.'</ul></div>';
  return $markup;
}


function america_blockquote( $atts, $content = null ) {
  extract(shortcode_atts(array(
    'type' => 'default',
    'align' => 'aligncenter',
  ), $atts));

  $markup = '<blockquote class="' . $type . ' ' . $align . '">';

  $markup .= $content . '</blockquote>';

  return $markup;
}
