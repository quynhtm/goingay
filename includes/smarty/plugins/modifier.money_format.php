<?php
// $Id: modifier.url.php,v 1.3 2005/12/31 09:38:51 tclineks Exp $

/*
 *
 * @param    int
 * @return   string
 */

function smarty_modifier_money_format($number)
{
  return call_user_func_array('bm_money_format', $number);
}

?>
