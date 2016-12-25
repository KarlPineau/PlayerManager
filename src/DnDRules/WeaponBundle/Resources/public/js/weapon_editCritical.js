$(document).ready(function() {
    function addPrototype(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name + ' n°' + (index+1) + ' :').replace(/__name__/g, index)));
    }
    
    var containerCriticals = $('div#dndrules_weaponbundle_weapon_edit_criticals');
                            $('div#dndrules_weaponbundle_weapon_edit_criticals').prev().hide();
    
    var index = containerCriticals.find(':input').length;
    if (index === 0) {
        addPrototype(containerCriticals, 'Critique', index);
        
        $('#dndrules_weaponbundle_weapon_edit_criticals_'+index).prev().addClass('col-md-3 control-label');
        $('#dndrules_weaponbundle_weapon_edit_criticals_'+index).addClass('col-md-9');
        
        $('#dndrules_weaponbundle_weapon_edit_criticals_'+index).html('<div class="row">' + $('#dndrules_weaponbundle_weapon_edit_criticals_'+index).html() + '</div>');
        
        $('#dndrules_weaponbundle_weapon_edit_criticals_'+index+'_rangeCriticalBegin').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_weaponbundle_weapon_edit_criticals_'+index+'_rangeCriticalBegin').wrap('<div class="col-md-2"></div>');
        $('#dndrules_weaponbundle_weapon_edit_criticals_'+index+'_rangeCriticalEnd').prev().wrap('<div class="col-md-1 control-label"></div>');
        $('#dndrules_weaponbundle_weapon_edit_criticals_'+index+'_rangeCriticalEnd').wrap('<div class="col-md-2"></div>');
        $('#dndrules_weaponbundle_weapon_edit_criticals_'+index+'_multiplier').prev().wrap('<div class="col-md-3 control-label"></div>');
        $('#dndrules_weaponbundle_weapon_edit_criticals_'+index+'_multiplier').wrap('<div class="col-md-2"></div>');
    }
});