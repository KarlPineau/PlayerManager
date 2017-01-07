$(document).ready(function() {
    // ----- PROTOTYPE
    function addPrototypeDamages(container, name, index) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, name + ' n°' + (index+1) + ' :')
            .replace(/dndinstance_weapon_weapon_edit_damages___name__/g, "dndinstance_weapon_weapon_edit_damages_"+index)
        ));
    }
    function addPrototypeDamage(container, index, index_Damage) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndinstance_weapon_weapon_edit_damages___name__/g, "dndinstance_weapon_weapon_edit_damages_"+index)
            .replace(/_damage___name__/g, "_damage_"+index_Damage)
        ));
    }
    function addPrototypeDiceEntities(container, index, index_Damage, index_damages_damage_diceEntities) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndinstance_weapon_weapon_edit_damages___name__/g, "dndinstance_weapon_weapon_edit_damages_"+index)
            .replace(/_damage___name__/g, "_damage_"+index_Damage)
            .replace(/_diceEntities___name__/g, "_diceEntities_"+index_damages_damage_diceEntities)
        ));
    }
    function addPrototypeBonusNumber(container, index, index_Damage, index_damages_damage_bonusNumber) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, '')
            .replace(/dndinstance_weapon_weapon_edit_damages___name__/g, "dndinstance_weapon_weapon_edit_damages_"+index)
            .replace(/_damage___name__/g, "_damage_"+index_Damage)
            .replace(/_bonusNumbers___name__/g, "_bonusNumbers_"+index_damages_damage_bonusNumber)
        ));
    }
    function addPrototypeCritical(container, name, index) {
        container.append($(container.attr('data-prototype')
            .replace(/__name__label__/g, name + ' n°' + (index+1) + ' :')
            .replace(/dndinstance_weapon_weapon_edit_criticals___name__/g, "dndinstance_weapon_weapon_edit_criticals_"+index)
        ));
    }


    // -------- DAMAGES
    function addDamages(container_damages, index) {
        addPrototypeDamages(container_damages, 'Dégâts', index);
        formatDamages(index);
    }
    function formatDamages(index) {
        if($('#dndinstance_weapon_weapon_edit_damages_'+index).prev().is('label')) {
            $('#dndinstance_weapon_weapon_edit_damages_'+index).prev().hide();
        }
        $('#dndinstance_weapon_weapon_edit_damages_'+index+'_size').prev().wrap('<div class="hidden"></div>');
        $('#dndinstance_weapon_weapon_edit_damages_'+index+'_size').wrap('<div class="col-md-2"></div>');

        var container_damage = $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage');
                               $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage').prev().hide();
        var index_Damage =     container_damage.children().length;
        //console.log(index_Damage);
        if(index_Damage == 0) {
            addDamage(container_damage, index, index_Damage);
            index_Damage++;
        } else {
            $.each(container_damage.children(), function() {
                formatDamage(index, $(this).index());
            });
        }
    }
    function addDamage(container_damage, index, index_Damage) {
        addPrototypeDamage(container_damage, index, index_Damage);
        formatDamage(index, index_Damage)
    }
    function formatDamage(index, index_Damage) {
        if($('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage).prev().is('label')) {
            $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage).prev().hide();
        }
        var container_damage_diceEntities =     $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_diceEntities');
                                                $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_diceEntities').prev().hide();
        var index_damages_damage_diceEntities = container_damage_diceEntities.children().length;
        if(index_damages_damage_diceEntities == 0) {
            addDiceEntities(index_damages_damage_diceEntities, index, index_Damage, index_damages_damage_diceEntities);
            index_damages_damage_diceEntities++;
        } else {
            $.each(container_damage_diceEntities.children(), function() {
                formatDiceEntities(index, index_Damage, $(this).index());
            });
        }

        var container_damage_bonusNumbers =    $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_bonusNumbers');
                                               $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_bonusNumbers').prev().hide();
        var index_damages_damage_bonusNumber = container_damage_bonusNumbers.children().length;
        if(index_damages_damage_bonusNumber == 0) {
            addBonusNumber(container_damage_bonusNumbers, index, index_Damage, index_damages_damage_bonusNumber);
            index_damages_damage_bonusNumber++;
        } else {
            $.each(container_damage_bonusNumbers.children(), function() {
                formatBonusNumber(index, index_Damage, $(this).index());
            });
        }

    }
    function addDiceEntities(index_damages_damage_diceEntities, index, index_Damage, index_damages_damage_diceEntities) {
        addPrototypeDiceEntities(index_damages_damage_diceEntities, index, index_Damage, index_damages_damage_diceEntities);
        formatDiceEntities(index, index_Damage, index_damages_damage_diceEntities);
    }
    function formatDiceEntities(index, index_Damage, index_damages_damage_diceEntities) {
        if($('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_diceEntities_'+index_damages_damage_diceEntities).prev().is('label')) {
            $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_diceEntities_'+index_damages_damage_diceEntities).prev().hide();
        }
        $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_diceEntities_'+index_damages_damage_diceEntities+'_diceNumber').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_diceEntities_'+index_damages_damage_diceEntities+'_diceNumber').wrap('<div class="col-md-2"></div>');
        $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_diceEntities_'+index_damages_damage_diceEntities+'_diceType').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_diceEntities_'+index_damages_damage_diceEntities+'_diceType').wrap('<div class="col-md-2"></div>');
    }
    function addBonusNumber(container_damage_bonusNumbers, index, index_Damage, index_damages_damage_bonusNumber) {
        addPrototypeBonusNumber(container_damages_bonusNumbers, index, index_Damage, index_damages_damage_bonusNumber);
        formatBonusNumber(index, index_Damage, index_damages_damage_bonusNumber);
    }
    function formatBonusNumber(index, index_Damage, index_damages_damage_bonusNumber) {
        if($('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_bonusNumbers_'+index_damages_damage_bonusNumber).prev().is('label')) {
            $('#dndinstance_weapon_weapon_edit_damages_'+index+'_damage_'+index_Damage+'_bonusNumbers_'+index_damages_damage_bonusNumber).prev().hide();
        }
        $('#dndinstance_weapon_weapon_edit_damages_'+index_Damage+'_damage_'+index+'_bonusNumbers_'+index_damages_damage_bonusNumber+'_value').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndinstance_weapon_weapon_edit_damages_'+index_Damage+'_damage_'+index+'_bonusNumbers_'+index_damages_damage_bonusNumber+'_value').wrap('<div class="col-md-2"></div>');
    }

    var container_damages = $('#dndinstance_weapon_weapon_edit_damages');
                            $('#dndinstance_weapon_weapon_edit_damages').prev().hide();
    var index =             container_damages.children().length;
    console.log(index);
    if(index == 0) {
        while(index < 2) {
            addDamages(container_damages, index);
            index++;
        }
    } else {
        $.each(container_damages.children(), function() {
            formatDamages($(this).index());
        });
    }

    /*container_damages.after('<button type="button" class="btn btn-primary" id="buttonAddDamage">Ajouter</button>');
    $('#buttonAddDamage').on('click', function() {
        addDamages(container_damages, index);
        index++;
    });*/

    // ---- CRITICAL
    function addCritical(containerCriticals, indexCritical) {
        addPrototypeCritical(containerCriticals, 'Critique', indexCritical);
        formatCritical(indexCritical);
    }
    function formatCritical(indexCritical) {
        $('#dndinstance_weapon_weapon_edit_criticals_'+indexCritical).prev().addClass('col-md-3 control-label');
        $('#dndinstance_weapon_weapon_edit_criticals_'+indexCritical).addClass('col-md-9');
        $('#dndinstance_weapon_weapon_edit_criticals_'+indexCritical).wrap('<div class="row"></div>');

        $('#dndinstance_weapon_weapon_edit_criticals_'+indexCritical+'_rangeCriticalBegin').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndinstance_weapon_weapon_edit_criticals_'+indexCritical+'_rangeCriticalBegin').wrap('<div class="col-md-2"></div>');
        $('#dndinstance_weapon_weapon_edit_criticals_'+indexCritical+'_rangeCriticalEnd').prev().wrap('<div class="col-md-1 control-label"></div>');
        $('#dndinstance_weapon_weapon_edit_criticals_'+indexCritical+'_rangeCriticalEnd').wrap('<div class="col-md-2"></div>');
        $('#dndinstance_weapon_weapon_edit_criticals_'+indexCritical+'_multiplier').prev().wrap('<div class="col-md-3 control-label"></div>');
        $('#dndinstance_weapon_weapon_edit_criticals_'+indexCritical+'_multiplier').wrap('<div class="col-md-2"></div>');
    }
    var containerCriticals = $('#dndinstance_weapon_weapon_edit_criticals');
                             $('#dndinstance_weapon_weapon_edit_criticals').prev().hide();

    var indexCritical = containerCriticals.children().length;
    if (indexCritical == 0) {
        addCritical(containerCriticals, indexCritical);
        index++;
    } else {
        $.each(containerCriticals.children(), function() {
            formatCritical($(this).index());
        });
    }
});