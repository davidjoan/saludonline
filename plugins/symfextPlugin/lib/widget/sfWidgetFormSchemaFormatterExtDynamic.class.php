<?php

/**
 * sfWidgetFormSchemaFormatterExtDynamic
 *
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormSchemaFormatterExtDynamic extends sfWidgetFormSchemaFormatterExt
{
  protected
    $rowFormat                 = "<tr>\n  <td class=\"label\">\n  <span %class%>%label%</span>\n</td>\n</tr>\n <tr>  <td class=\"field\">\n  %field%%help%%hidden_fields% \n</td>\n</tr>\n";
}
