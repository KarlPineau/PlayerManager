$(document).ready(function() {
    function addPrototype(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name + ' ').replace(/__name__/g, index)));
    }
    var container_damages = $('div#dndrules_weaponbundle_weapon_register_damages');
                            $('div#dndrules_weaponbundle_weapon_register_damages').prev().hide();
    
    for(var index = 0; index < 2 ; index++) {
        addPrototype(container_damages, 'Dégâts', index);
        
        $('#dndrules_weaponbundle_weapon_register_damages_'+index).prev().addClass('col-md-2 control-label');
        $('#dndrules_weaponbundle_weapon_register_damages_'+index).addClass('col-md-10');
        $('#dndrules_weaponbundle_weapon_register_damages_'+index).html('<div class="row">' + $('#dndrules_weaponbundle_weapon_register_damages_'+index).html() + '</div>');
        
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_size').prev().wrap('<div class="hidden"></div>');
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_size').wrap('<div class="col-md-2"></div>');
        
        var container_damages_diceEntities = $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage');
                                             $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage').prev().hide();
        addPrototype(container_damages_diceEntities, '', index);
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage').html('<div class="col-md-10">'+$('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage').html()+'</div>');
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index).prev().hide();
        
        
        var container_damages_diceEntities = $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_diceEntities');
                                             $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_diceEntities').prev().hide();
        addPrototype(container_damages_diceEntities, 'Dé', index);
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_diceEntities_'+index).prev().hide();
        
        var container_damages_bonusNumbers = $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_bonusNumbers');
                                             $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_bonusNumbers').prev().hide();
        addPrototype(container_damages_bonusNumbers, 'Bonus', index);
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_bonusNumbers_'+index).prev().hide();
        
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_diceEntities_'+index+'_diceNumber').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_diceEntities_'+index+'_diceNumber').wrap('<div class="col-md-2"></div>');
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_diceEntities_'+index+'_diceType').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_diceEntities_'+index+'_diceType').wrap('<div class="col-md-2"></div>');
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_bonusNumbers_'+index+'_value').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_weaponbundle_weapon_register_damages_'+index+'_damage_'+index+'_bonusNumbers_'+index+'_value').wrap('<div class="col-md-2"></div>');
    }
});