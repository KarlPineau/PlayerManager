$(document).ready(function() {
    function addContainerAttackInstances(container, name, index) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndrules_monsterbundle_monster_attacks_attackInstances___name__/g, "dndrules_monsterbundle_monster_attacks_attackInstances_"+index)));
    }
    
    function addAttackInstances(container, index) {
        addContainerAttackInstances(container, '', index);
        format(index);
    }

    function format(index) {
        if($('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index).prev().is('label')) {
            $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index).prev().hide();
        }
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index).parent().addClass('well').css('margin-top', '10px');

        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_name').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_name').wrap('<div class="col-sm-9"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_name').parent().parent().addClass('form-group');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_name').addClass('form-control');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_name').attr('placeholder', 'Épée à deux mains de maître');

        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_bab').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_bab').wrap('<div class="col-sm-9"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_bab').parent().parent().addClass('form-group');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_bab').addClass('form-control');

        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageSideEffect').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageSideEffect').wrap('<div class="col-sm-9"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageSideEffect').parent().parent().addClass('form-group');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageSideEffect').addClass('form-control');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageSideEffect').attr('placeholder', '');

        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_weapon').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_weapon').wrap('<div class="col-sm-9"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_weapon').parent().parent().addClass('form-group');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_weapon').addClass('form-control');


        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms').wrap('<div class="col-sm-9"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms').parent().parent().addClass('form-group');
        var containerDamageForms = $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms');
                                   $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms').prev().remove();
        var indexDamageForms =     containerDamageForms.children().length;
        if (indexDamageForms == 0) {
            addDamageForms(containerDamageForms, index, indexDamageForms); indexDamageForms++;
        } else {
            $.each(containerDamageForms.children(), function() {
                formatDamageForms(index, $(this).index());
            });
        }

        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_onlyExtreme').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_onlyExtreme').wrap('<div class="col-sm-9"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_onlyExtreme').parent().parent().addClass('form-group');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_onlyExtreme').addClass('form-control');

        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms').parent().parent().after('' +
            '<div class="row">' +
            '   <div class="col-sm-9 col-sm-offset-3 col-xs-12">' +
            '       <button type="button" class="btn btn-block btn-default" id="addDamageForms-'+index+'" aria-value="'+ index +'"><i class="fa fa-plus"></i> Ajouter un dé de dommage</button>' +
            '   </div>' +
            '</div>');
        $('#addDamageForms-'+index).on('click', function() {
            addDamageForms(containerDamageForms, index, indexDamageForms); indexDamageForms++;
        });


        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms').css('margin-top', '10px');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms').wrap('<div class="col-sm-9"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms').parent().parent().addClass('form-group');
        var containerDamageCriticForms = $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms');
                                        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms').prev().remove();
        var indexDamageCriticForms =     containerDamageCriticForms.children().length;
        if (indexDamageCriticForms == 0) {
            addDamageCriticForms(containerDamageCriticForms, index, indexDamageCriticForms); indexDamageCriticForms++;
        } else {
            $.each(containerDamageCriticForms.children(), function() {
                formatDamageCriticForms(index, $(this).index());
            });
        }
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms').parent().parent().after('' +
            '<div class="row">' +
            '   <div class="col-sm-9 col-sm-offset-3 col-xs-12">' +
            '       <button type="button" class="btn btn-block btn-default" id="addDamageCriticForms-'+index+'" aria-value="'+ index +'"><i class="fa fa-plus"></i> Ajouter un Critique</button>' +
            '   </div>' +
            '</div>');
        $('#addDamageCriticForms-'+index).on('click', function() {
            addDamageCriticForms(containerDamageCriticForms, index, indexDamageCriticForms); indexDamageCriticForms++;
        });


        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index)
            .prepend(''+
                '<div class="text-right">'+
                '    <button type="button" class="btn btn-warning" id="btn-remove-dndrules_monsterbundle_monster_attacks_attackInstances-'+index+'"><i class="fa fa-remove"></i></button>'+
                '</div><br />');

        $('#btn-remove-dndrules_monsterbundle_monster_attacks_attackInstances-'+index).on("click", function() {
            $(this).parent().parent().parent().remove();
        });
    }
    
    var containerAttackInstances = $('div#dndrules_monsterbundle_monster_attacks_attackInstances');
    var index = containerAttackInstances.children().length;
    if(index > 0) {
        $.each(containerAttackInstances.children(), function () {
            format($(this).index());
        });
    }
    
    $('div#dndrules_monsterbundle_monster_attacks_attackInstances')
    .prepend(''+
            '<div class="row">'+
            '    <div class="col-md-offset-10 col-md-2">'+
            '        <button type="button" class="btn btn-primary btn-block" id="btn-attackinstances-add"><i class="fa fa-plus"></i> Attaque</button>'+
            '    </div>'+
            '</div>');
    
    $('#btn-attackinstances-add').on("click", function() {
        addAttackInstances(containerAttackInstances, index);
        index++;
    });


    //--------
    function addContainer(container, index, indexDamageForms) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndrules_monsterbundle_monster_attacks_attackInstances___name__/g, 'dndrules_monsterbundle_monster_attacks_attackInstances_'+index)
            .replace(/_damageForms___name__/g, '_damageForms_'+indexDamageForms)));
    }
    function addContainer2(container, index, indexDamageForms, index_diceEntities) {
        console.log(index+'<>'+indexDamageForms+'<>'+index_diceEntities+'<>');
        console.log($(container.attr('data-prototype')));
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndrules_monsterbundle_monster_attacks_attackInstances___name__/g, 'dndrules_monsterbundle_monster_attacks_attackInstances_'+index)
            .replace(/_damageForms___name__/g, '_damageForms_'+indexDamageForms)
            .replace(/_diceEntities___name__/g, '_diceEntities_'+index_diceEntities)));
    }
    function addContainer3(container, index, indexDamageForms, index_bonusNumber) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndrules_monsterbundle_monster_attacks_attackInstances___name__/g, 'dndrules_monsterbundle_monster_attacks_attackInstances_'+index)
            .replace(/_damageForms___name__/g, '_damageForms_'+indexDamageForms)
            .replace(/_bonusNumbers___name__/g, '_bonusNumbers_'+index_bonusNumber)));
    }
    function addDamageForms(container, index, indexDamageForms) {
        addContainer(container, index, indexDamageForms);
        formatDamageForms(index, indexDamageForms);
    }
    function formatDamageForms(index, indexDamageForms) {
        var container_diceEntities = $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_diceEntities');
        var index_diceEntities =     container_diceEntities.children().length;
        if (index_diceEntities === 0) {
            addDiceEntities(container_diceEntities, index, indexDamageForms, index_diceEntities); index_diceEntities++;
        } else {
            $.each(container_diceEntities.children(), function() {
                formatDiceEntities(index, indexDamageForms, $(this).index());
            });
        }

        var container_bonusNumber = $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_bonusNumbers');
        var index_bonusNumber =     container_bonusNumber.children().length;
        if (index_bonusNumber === 0) {
            addBonusNumber(container_bonusNumber, index, indexDamageForms, index_bonusNumber); index_bonusNumber++;
        } else {
            $.each(container_bonusNumber.children(), function() {
                formatBonusNumber(index, indexDamageForms, $(this).index());
            });
        }

        if($('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms).prev().is('label')) {
            $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms).prev().hide();
        }
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms).parent().addClass('row');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_diceEntities').parent().addClass('col-md-6');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_bonusNumbers').parent().addClass('col-md-4');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_diceEntities').prev().remove();
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_bonusNumbers').prev().remove();
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms).append('' +
            '<div class="col-sm-2 text-right" style="margin-top: 20px;">' +
            '   <button type="button" class="btn btn-warning" id="remove-dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'"><i class="fa fa-remove"></i></button>' +
            '</div>');
        $('#remove-dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms).on('click', function() {
            $(this).parent().parent().parent().remove();
        });
    }
    function addDiceEntities(container, index, indexDamageForms, index_diceEntities) {
        addContainer2(container, index, indexDamageForms, index_diceEntities);
        formatDiceEntities(index, indexDamageForms, index_diceEntities);
    }
    function formatDiceEntities(index, indexDamageForms, index_diceEntities) {
        if($('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_diceEntities_'+index_diceEntities).prev().is('label')) {
            $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_diceEntities_'+index_diceEntities).prev().hide();
        }
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_diceEntities_'+index_diceEntities+'_diceNumber').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_diceEntities_'+index_diceEntities+'_diceNumber').wrap('<div class="col-sm-3"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_diceEntities_'+index_diceEntities+'_diceType').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_diceEntities_'+index_diceEntities+'_diceType').wrap('<div class="col-sm-3"></div>');
    }
    function addBonusNumber(container, index, indexDamageForms, index_bonusNumber) {
        addContainer3(container, index, indexDamageForms, index_bonusNumber);
        formatBonusNumber(index, indexDamageForms, index_bonusNumber);
    }
    function formatBonusNumber(index, indexDamageForms, index_bonusNumber) {
        if($('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_bonusNumbers_'+index_bonusNumber).prev().is('label')) {
            $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_bonusNumbers_'+index_bonusNumber).prev().hide();
        }
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_bonusNumbers_'+index_bonusNumber+'_value').prev().wrap('<div class="col-sm-6 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageForms_'+indexDamageForms+'_bonusNumbers_'+index_bonusNumber+'_value').wrap('<div class="col-sm-6"></div>');
    }

    //----------------------------
    function addContainerCritic(container, index, indexDamageCriticForms) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndrules_monsterbundle_monster_attacks_attackInstances___name__/g, 'dndrules_monsterbundle_monster_attacks_attackInstances_'+index)
            .replace(/_damageCriticForms___name__/g, '_damageCriticForms_'+indexDamageCriticForms)));
    }
    function addDamageCriticForms(container, index, indexDamageCriticForms) {
        addContainerCritic(container, index, indexDamageCriticForms);
        formatDamageCriticForms(index, indexDamageCriticForms);
    }
    function formatDamageCriticForms(index, indexDamageCriticForms) {
        if($('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms).prev().is('label')) {
            $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms).prev().hide();
        }
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms).parent().addClass('row');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms+'_rangeCriticalBegin').prev().wrap('<div class="col-sm-1 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms+'_rangeCriticalBegin').prev().text('Plage');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms+'_rangeCriticalBegin').wrap('<div class="col-sm-2"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms+'_rangeCriticalEnd').prev().wrap('<div class="col-sm-1 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms+'_rangeCriticalEnd').wrap('<div class="col-sm-2"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms+'_multiplier').prev().wrap('<div class="col-sm-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms+'_multiplier').wrap('<div class="col-sm-2"></div>');
        $('#dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms).append('' +
            '<div class="col-sm-2 text-right">' +
            '   <button type="button" class="btn btn-warning" id="remove-dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms+'"><i class="fa fa-remove"></i></button>' +
            '</div>');
        $('#remove-dndrules_monsterbundle_monster_attacks_attackInstances_'+index+'_damageCriticForms_'+indexDamageCriticForms).on('click', function() {
            $(this).parent().parent().parent().remove();
        });
    }

});