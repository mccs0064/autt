<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/onoff.css"
      media="screen, projection"/>

<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-body">
            <h3><?php echo $model->isNewRecord ? 'Build' : 'Update'; ?> Inspection</h3>
        </div>
    </div>
    <!-- END PANEL -->
</div>
<div class="col-sm-12">
    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'add-template-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,

                ),
                'htmlOptions'=>array( 'onsubmit'=>'return submitForm()')
            ));
            ?>
            <?php
            $errors = $model->getErrors();
            if (!empty($errors)):?>
                <div class="alert alert-danger">
                    <?php echo $form->errorSummary($model); ?>
                </div>
            <?php endif; ?>

           <div class="row">
               <div class="col-xs-8">
                   <div class="form-group form-group-default required">
                       <?php echo $form->label($model, 'template_name'); ?>
                       <?php echo $form->textField($model, 'template_name', array('placeholder' => 'Enter Template name', 'class' => 'form-control', 'required' => true,'id'=>'template_name')); ?>
                   </div>

                   <div class="row">
                       <div class="col-xs-9">
                           <div class="form-group form-group-default">
                               <?php echo CHtml::textField('checklist_item', '', array('class' => 'form-control', 'id' => 'defect-input', 'placeholder' => 'Defect Name')) ?>
                           </div>
                       </div>
                       <div class="col-xs-3">

                           <?php echo CHtml::button('Add', array('class' => 'btn btn-success', 'id' => 'add-btn')); ?>

                       </div>
                   </div>
               </div>
           </div><br/><br/>

            <div class="row">
            <div class="col-xs-12 text-right">
                <?php if($model->isNewRecord==false):?>
                    <?php
                    $dateUpdated=new DateTime($model->udpated_at, new DateTimeZone('UTC'));
                    $dateUpdated->setTimezone(new DateTimeZone('Europe/London'));
                    echo "Last Updated at: ". $dateUpdated->format('d/m/Y h:i');?>
                <?php endif;?>
            </div>
            </div>



            <div class="table-responsive" id="fleet-manager-driver-grid">
                <div class="summary"><strong>Build Defects List</strong></div>
                <table class="table table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>Defect ID</th>
                        <th>Defect Name</th>
                        <th>Show/Hide</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="defect-rows">
                    <?php if(!empty($items)):
                        foreach ($items as $item):
                            $this->renderPartial('_defectitem',array('id'=>$item['id'],'name'=>$item['name'],'visible'=>$item['visible'],'db_id'=>'1'));
                        endforeach;
                     endif;?>
                    </tbody>
                </table>
                </div>
            </div>


            <div class="m-t-20" style="margin-bottom:20px;">

                <a href="<?php echo Yii::app()->request->baseUrl; ?>/fleetmanager/inspectiontemplates"
                   class="btn btn-default pull-right"><i class="pg-close"></i> Cancel</a>
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Update', array('class' => 'btn btn-success pull-right')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<div class="hidden" data-record-id="<?php echo $model->id;?>" id="record_type">
<?php echo $model->isNewRecord==true?'1':'0';?>
</div>

<div class="modal fade slide-up" id="edit-defect-name-modal" tabindex="-1" role="dialog" aria-hidden="false" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5><span class="semi-bold">Update Defect Name</span></h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" id="new_defect_name" class="form-control"/>
                        <input type="hidden" id="defect_name_id"/>
                        <br/>
                        <button class="btn btn-primary" onclick="updateDefectName()">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>


<script>
    $("#add-btn").click(function () {
        var defect_name=$("#defect-input").val();
        if(defect_name.length>0)
        {
            var last_id=0;
            if($(".defect-row").length>0)
            {
                last_id=$(".defect-row").last().find("td").eq(0).attr('id');
            }
            $.ajax({
                type: 'post',
                url: '<?php echo Yii::app()->createUrl("fleetmanager/inspectiontemplates/addrow");?>',
                data: {last_id: last_id,defect_name:defect_name},
                success: function (response) {
                    var resp=$.parseJSON(response);
                    $("#defect-rows").append(resp.html);
                    $("#defect-input").val('');
                }
            });
        }
    });

    function submitForm () {
        var record_id=$("#record_type").attr('data-record-id');
        var template_name=$("#template_name").val();
        var defects=[];
        $(".defect-row").each(function () {
            var defect={};

            defect.name=$(this).find('td').eq(1).text();
            defect.visible=$(this).find('td').eq(2).find('input').prop("checked");
            defect.isOld=$(this).find('td').eq(0).attr('data-db_id');
            defect.id=$(this).find('td').eq(0).attr('id');
            defects.push(defect);
            
        });


        $.ajax({
            type: 'post',
            url: '<?php echo Yii::app()->createUrl("fleetmanager/inspectiontemplates/template");?>',
            data: {template_name: template_name,defects:defects,record_id:record_id},
            success: function (response) {
                    window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspectiontemplates';
            }
        });

        return false;
    }

    $(document.body).on('click','.remove-defect',function(){
        $(this).parent().parent().remove()
    });

    $(document.body).on('click','.delete-defect',function(){
        var choice=window.confirm('Are you sure you want to remove this defect from list?');
        if(choice==true)
        {
            var defect_id=$(this).attr('data-id');
            var $this=$(this);
            $.ajax({
                type: 'post',
                url: '<?php echo Yii::app()->createUrl("fleetmanager/inspectiontemplates/deletedefect");?>',
                data: {defect_id: defect_id},
                success: function () {
                    $this.parent().parent().remove();
                }
            });
        }

    });
    function updateDefectName() {
        var defectName=$("#new_defect_name").val();
        if(defectName=='')
        {
            alert('Please enter the name of the defect');
            return false;
        }
        var defectId= $("#defect_name_id").val();
        $("[data-defect-row='"+defectId+"']").find('td').eq(1).text(defectName);
        $("#edit-defect-name-modal").modal('hide');
    }
    
    function editDefectName(defectName,id) {

        $("#new_defect_name").val(defectName);
        $("#defect_name_id").val(id);
        $("#edit-defect-name-modal").modal('show');
    }
</script>