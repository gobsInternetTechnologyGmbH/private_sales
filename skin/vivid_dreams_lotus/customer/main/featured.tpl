{*
$Id: featured.tpl,v 1.1 2010/05/21 08:33:03 joy Exp $
vim: set ts=2 sw=2 sts=2 et:
*}
{if $f_products ne ""}
  {capture name=dialog}
    {include file="customer/main/products.tpl" products=$f_products featured="Y"}
  {/capture}
  {include file="customer/dialog.tpl" title=$lng.lbl_featured_products content=$smarty.capture.dialog title_page="Y"}
{/if}
