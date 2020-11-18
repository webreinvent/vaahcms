<?php
if($data){
foreach ($data as $item)
{
?>
{{$item['key']}}={{$item['value']}}
<?php }} ?>
