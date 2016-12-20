$(document).ready(function() {
    function addContainer(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name).replace(/__name__/g, index)));
    }
    
    function addHpForm(container, index) {
        addContainer(container, '', index);
              
        var container_diceEntities = $('div#dndrules_monsterbundle_monster_register_hpForm_'+index+'_diceEntities');
                                     $('div#dndrules_monsterbundle_monster_register_hpForm_'+index+'_diceEntities').prev().hide();
        var index_diceEntities = container_diceEntities.find(':input').length;

        if (index_diceEntities === 0) {
            addDiceEntities(container_diceEntities, index_diceEntities);
            index_diceEntities++;
        }

        var container_bonusNumber = $('div#dndrules_monsterbundle_monster_register_hpForm_'+index+'_bonusNumbers');
                                    $('div#dndrules_monsterbundle_monster_register_hpForm_'+index+'_bonusNumbers').prev().hide();
        var index_bonusNumber = container_bonusNumber.find(':input').length;

        if (index_bonusNumber === 0) {
            addBonusNumber(container_bonusNumber, index_bonusNumber);
            index_bonusNumber++;
        }
    }
    
    function addDiceEntities(container, index) {
        addContainer(container, '', index);
              
        $('#dndrules_monsterbundle_monster_register_hpForm_'+index+'_diceEntities_'+index+'_diceNumber').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_register_hpForm_'+index+'_diceEntities_'+index+'_diceNumber').wrap('<div class="col-md-2"></div>');
        $('#dndrules_monsterbundle_monster_register_hpForm_'+index+'_diceEntities_'+index+'_diceType').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_register_hpForm_'+index+'_diceEntities_'+index+'_diceType').wrap('<div class="col-md-2"></div>');
        
    }
    
    function addBonusNumber(container, index) {
        addContainer(container, '', index);
              
        $('#dndrules_monsterbundle_monster_register_hpForm_'+index+'_bonusNumbers_'+index+'_value').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_register_hpForm_'+index+'_bonusNumbers_'+index+'_value').wrap('<div class="col-md-2"></div>');
    }
    
    var containerHpForm = $('div#dndrules_monsterbundle_monster_register_hpForm');
                                 $('div#dndrules_monsterbundle_monster_register_hpForm').prev().hide();
    var index = containerHpForm.find(':input').length;
    
    if (index === 0) {
        addHpForm(containerHpForm, index);
        index++;
    }
});