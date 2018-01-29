<tr class="defect-row" data-defect-row="<?php echo $id;?>">
    <td id="<?php echo $id;?>" data-db_id="<?php echo $db_id;?>"><?php echo Yii::app()->commons->createIdInspection($id,'DEF');?></td>
    <td><?php echo $name;?></td>
    <td>
        <div class="onoffswitch">
            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch-<?php echo $id;?>" <?php echo $visible==1?'checked':'';?>>
            <label class="onoffswitch-label" for="myonoffswitch-<?php echo $id;?>">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
            </label>
        </div>
    </td>
    <td class="button-column">
        <a class="btn btn-primary" onclick="editDefectName('<?php echo $name;?>','<?php echo $id;?>')">Edit</a>
        <a class="btn btn-primary <?php echo $db_id=='1'?'delete-defect':'remove-defect';?>" data-id="<?php echo $id;?>">Delete</a>
    </td>
</tr>