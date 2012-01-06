<?php

/**
 * sfWidgetFormSchemaFormatterExtendedRow
 *
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormSchemaFormatterExtendedRow extends sfWidgetFormSchemaFormatterExt
{
  protected
    $rowFormat                 = "<td class=\"label\">\n  <span %class%>%label%</span>\n</td>\n  <td class=\"field\">\n  %field%%help%%hidden_fields% \n</td>\n";
}
