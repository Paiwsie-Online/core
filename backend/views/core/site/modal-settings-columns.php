<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/* @var $this yii\web\View */
/* @var $columns */

$form = ActiveForm::begin();

if ($columns !== '') {
    ?>
    <table class="table table-striped table-bordered modalTable" style="width: 100%">
        <?php
        foreach ($columns as $key => $value) {
            echo '<tr>
                    <td class="poppinsStrong p-1">
                        <span class="float-right pt-1">
                            <a class="btn btn-sm buttonTransparent moveUp"><i class="fas fa-arrow-alt-up fa-2x" style="color: #FFC107"></i></a>
                            <a class="btn btn-sm buttonTransparent moveDown"><i class="fas fa-arrow-alt-down fa-2x" style="color: #D56A59"></i></a>
                            <a class="btn btn-sm buttonTransparent moveFirst"><i class="fas fa-arrow-alt-to-top fa-2x" style="color: #BFC7D3"></i></a>
                            <a class="btn btn-sm buttonTransparent moveLast"><i class="fas fa-arrow-alt-to-bottom fa-2x" style="color: #888888"></i></a>
                        </span>
                        <label class="pt-2 pl-4"><input type="checkbox" value="' . $key . '" name="' . $key . '" ' . ($value['checked'] == true ? 'checked' : '') . ' onclick="checkCheckBoxes()"> ' . Yii::t('core_model', $value['label']) . '</label>
                    </td>
                </tr>';
        }
        ?>
    </table>
    <div class="col-12 mb-2">
        <?= Html::submitButton(Yii::t('core_system', 'Save'), ['class' => 'btn btn-warning', 'id' => 'saveButton']) ?>
    </div>
    <?php
}
?>

<?php ActiveForm::end(); ?>

<script>

    $(document).ready(function() {
        checkTableRows();
    });

    function checkCheckBoxes() {
        if ($('input').is(':checked')) {
            $('#saveButton').prop('disabled', false);
        } else {
            $('#saveButton').prop('disabled', true);
        }
    }

    $('.moveUp').click(function() {
        var row = $(this).parents('tr:first');
        row.hide(250);
        row.insertBefore(row.prev());
        row.show(250);
        checkTableRows();
    });

    $('.moveDown').click(function() {
        var row = $(this).parents('tr:first');
        row.hide(250);
        row.insertAfter(row.next());
        row.show(250);
        checkTableRows();
    });

    $('.moveFirst').click(function() {
        var row = $(this).parents('tr:first');
        row.hide(250);
        row.insertBefore($('.modalTable tr:first'));
        row.show(250);
        checkTableRows();
    });

    $('.moveLast').click(function() {
        var row = $(this).parents('tr:first');
        row.hide(250);
        row.insertAfter($('.modalTable tr:last'));
        row.show(250);
        checkTableRows();
    });

    function checkTableRows() {
        $('.fa-arrow-alt-up').css({color: '#FFC107'});
        $('.moveUp').removeClass('disabled');
        $('.fa-arrow-alt-down').css({color: '#D56A59'});
        $('.moveDown').removeClass('disabled');
        $('.fa-arrow-alt-to-top').css({color: '#BFC7D3'});
        $('.moveFirst').removeClass('disabled');
        $('.fa-arrow-alt-to-bottom').css({color: '#888888'});
        $('.moveLast').removeClass('disabled');
        $('.modalTable tr:first').find('.fa-arrow-alt-up').css({color: 'transparent'});
        $('.modalTable tr:first').find('.moveUp').addClass('disabled');
        $('.modalTable tr:first').find('.fa-arrow-alt-to-top').css({color: 'transparent'});
        $('.modalTable tr:first').find('.moveFirst').addClass('disabled');
        $('.modalTable tr:last').find('.fa-arrow-alt-down').css({color: 'transparent'});
        $('.modalTable tr:last').find('.moveDown').addClass('disabled');
        $('.modalTable tr:last').find('.fa-arrow-alt-to-bottom').css({color: 'transparent'});
        $('.modalTable tr:last').find('.moveLast').addClass('disabled');
    }

</script>