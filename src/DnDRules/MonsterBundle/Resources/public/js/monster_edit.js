$(document).ready(function() {
    function addContainer(container, index) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndrules_monsterbundle_monster_edit_hpForm___name__/g, 'dndrules_monsterbundle_monster_edit_hpForm_'+index)));
    }
    function addContainerDiceEntities(container, index, index_diceEntities) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndrules_monsterbundle_monster_edit_hpForm___name__/g, 'dndrules_monsterbundle_monster_edit_hpForm_'+index)
            .replace(/_diceEntities___name__/g, '_diceEntities_'+index_diceEntities)));
    }
    function addContainerBonusNumber(container, index, index_bonusNumber) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndrules_monsterbundle_monster_edit_hpForm___name__/g, 'dndrules_monsterbundle_monster_edit_hpForm_'+index)
            .replace(/_bonusNumbers___name__/g, '_bonusNumbers_'+index_bonusNumber)));
    }
    
    function addHpForm(container, index) {
        addContainer(container, index);
        formatHpForm(index);
    }
    function formatHpForm(index) {
        var container_diceEntities =  $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_diceEntities');
                                      $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_diceEntities').prev().hide();
        var index_diceEntities =      container_diceEntities.children().length;
        if (index_diceEntities === 0) { addDiceEntities(container_diceEntities, index, index_diceEntities); index_diceEntities++;}
        else {
            $.each(container_diceEntities.children(), function() {
                formatDiceEntities(index, $(this).index());
            });
        }

        var container_bonusNumber =  $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_bonusNumbers');
                                     $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_bonusNumbers').prev().hide();
                                     $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_bonusNumbers').parent().css('margin-top', '-20px');
        var index_bonusNumber =      container_bonusNumber.children().length;
        if (index_bonusNumber === 0) { addBonusNumber(container_bonusNumber, index, index_bonusNumber); index_bonusNumber++; }
        else{
            $.each(container_bonusNumber.children(), function() {
                formatBonusNumber(index, $(this).index());
            });
        }

        if($('#dndrules_monsterbundle_monster_edit_hpForm_'+index).prev().is('label')) {
            $('#dndrules_monsterbundle_monster_edit_hpForm_'+index).prev().hide();
            $('#dndrules_monsterbundle_monster_edit_hpForm_'+index).addClass('row');
        }

        $('#dndrules_monsterbundle_monster_edit_hpForm_'+index).append('' +
            '<div class="col-sm-1">' +
            '   <button type="button" class="btn btn-warning" id="remove-dndrules_monsterbundle_monster_edit_hpForm_'+index+'"><i class="fa fa-remove"></i></button>' +
            '</div>');
        $('#remove-dndrules_monsterbundle_monster_edit_hpForm_'+index).on('click', function() {
            $(this).parent().parent().parent().remove();
        });
    }
    function addDiceEntities(container, index, index_diceEntities) {
        addContainerDiceEntities(container, index, index_diceEntities);
        formatDiceEntities(index, index_diceEntities);
    }
    function formatDiceEntities(index, index_diceEntities) {
        if($('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_diceEntities_'+index_diceEntities).prev().is('label')){$('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_diceEntities_'+index_diceEntities).prev().hide();}
        $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_diceEntities_'+index_diceEntities+'_diceNumber').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_diceEntities_'+index_diceEntities+'_diceNumber').wrap('<div class="col-md-2"></div>');
        $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_diceEntities_'+index_diceEntities+'_diceType').prev().wrap('<div class="col-md-1 control-label"></div>');
        $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_diceEntities_'+index_diceEntities+'_diceType').wrap('<div class="col-md-2"></div>');
    }
    function addBonusNumber(container, index, index_bonusNumber) {
        addContainerBonusNumber(container, index, index_bonusNumber);
        formatBonusNumber(index, index_bonusNumber);
    }
    function formatBonusNumber(index, index_bonusNumber) {
        if($('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_bonusNumbers_'+index_bonusNumber).prev().is('label')){$('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_bonusNumbers_'+index_bonusNumber).prev().hide();}
        $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_bonusNumbers_'+index_bonusNumber+'_value').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_edit_hpForm_'+index+'_bonusNumbers_'+index_bonusNumber+'_value').wrap('<div class="col-md-2"></div>');
    }
    
    var containerHpForm = $('#dndrules_monsterbundle_monster_edit_hpForm');
    var index = containerHpForm.children().length;
    if (index === 0) { addHpForm(containerHpForm, index); index++; }
    else {
        $.each(containerHpForm.children(), function() {
            formatHpForm($(this).index());
        });
    }

    $('#dndrules_monsterbundle_monster_edit_hpForm').parent().parent().after('<br />' +
        '<div class="row">' +
        '   <div class="col-sm-offset-3 col-sm-9">' +
        '       <button type="button" class="btn btn-block btn-default" id="add-hpForm"><i class="fa fa-plus"></i> Ajouter un dé</button>' +
        '   </div>' +
        '</div>');
    $('#add-hpForm').on('click', function() {
        addHpForm(containerHpForm, index); index++;
    });
});