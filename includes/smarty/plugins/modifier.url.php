<?php
// $Id: modifier.url.php,v 1.3 2005/12/31 09:38:51 tclineks Exp $

/**
 * Smarty Drupal {url} modifier plugin example
 *
 * Example Smarty modifier plugin to provide template access to
 * the Drupal function 'url'
 * @link http://drupaldocs.org/api/head/function/t
 *
 * Examples:
 * {"Message to put into current locale"|url}
 *
 * @param    string
 * @return   string
 */

function smarty_modifier_url($string)
{
  return call_user_func_array('get_url', $string);
}

?>
