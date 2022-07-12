<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
/* @var $this yii\web\View */

?>

<div class="row p-3">
    <div class="col-md-8 offset-1">
        <input type="text" class="form-control" id="newTypeInp">
        <?= Yii::warning("Division by zero.") ?>
    </div>
    <div class="col-md-2">
        <a class="btn btn-warning" id="btnConfirm"><?= Yii::t('core_system', 'Add') ?></a>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#newTypeInp').keyup(function() {
            var typeVal = $('#newTypeInp').val();
            var typeValCorrect = typeVal.replace(" ", "_");
            $('#newTypeInp').val(typeValCorrect);
        });

        $('#btnConfirm').click(function() {
            var type = $('#newTypeInp').val();
            $('#enumeration-enumerator').append(
                '<option value="' + type + '">' + type + '</option>'
            );
            $('#site-modal').modal('hide');
        });
    });
</script>