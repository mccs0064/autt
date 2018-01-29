<tr class="defect-row" id="<?php echo $id;?>" data-content="">
    <td><?php echo "DEF-000".$id;?></td>
    <td><?php echo $name;?></td>
    <td class="button-column">
        <a class="btn btn-primary add-note-btn" onclick="addNote(<?php echo $id;?>)">Add Note</a>
    </td>
    <td>
        <div class="onoffswitch">
            <input type="checkbox" onchange="changeDefectStatus(this)" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch-<?php echo $id;?>" <?php echo $visible==1?'checked':'';?>>
            <label class="onoffswitch-label" for="myonoffswitch-<?php echo $id;?>">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
            </label>
        </div>
    </td>
</tr>