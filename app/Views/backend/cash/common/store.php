<tr>
    <form class="object-form" action="" method="post">
        <th style="width: 35px;">
            <input type="checkbox" id="checkbox-all">
            <label for="check-all" class="labelCheckAll"></label>
        </th>
        <th>
            <?php echo form_input('title', set_value('title', (isset($object['title'])) ? $object['title'] : ''), 'class="form-control input "  placeholder="" autocomplete="off"');?>
            <?php echo form_input('id', set_value('id', (isset($object['id'])) ? $object['id'] : 0), 'class="form-control input" placeholder="" autocomplete="off" id="id" style="display:none;"');?>
        </th>
        <?php $cash_catalogue = cash_catalogue();  ?>
        <th>
            <?php if(isset($cash_catalogue) && is_array($cash_catalogue) && count($cash_catalogue)){ ?>
            <?php echo form_dropdown('catalogueid',$cash_catalogue, $object['catalogueid'],' class="form-control input select2"') ?>
            <?php } ?>
        </th>
        <th>
            <?php echo form_input('money_collect', set_value('money_collect', (isset($object['money_collect'])) ? $object['money_collect'] : ''), 'class="form-control input-sm int text-center "   autocomplete="off"');?>
        </th>
        <th>
             <?php echo form_input('money_pay', set_value('money_pay', (isset($object['money_pay'])) ? $object['money_pay'] : ''), 'class="form-control input-sm int text-center "   autocomplete="off"');?> 
        </th>
        <th class="text-center">
            <?php echo form_input('description', set_value('description', (isset($object['description'])) ? $object['description'] : ''), 'class="form-control input-sm "   autocomplete="off"');?> 
        </th>
        <th>
            
        </th>
        <th>
            <button type="submit" class="btn btn-primary saveButton"><i class="fa fa-plus" aria-hidden="true"></i> Lưu</button>
        </th>
    </form>
</tr>
