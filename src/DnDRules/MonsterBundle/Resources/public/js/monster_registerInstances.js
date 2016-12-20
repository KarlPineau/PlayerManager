$(document).ready(function() {
    function addContainerAbilityInstances(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name).replace(/__name__/g, index)));
    }
    
    function removeAbilityInstances(button) {
        button.parent().parent().remove();
    }
    
    function addAbilityInstances(container, index) {
        addContainerAbilityInstances(container, '', index);
        
        $('#dndrules_monsterbundle_monster_register_abilityInstances_'+index+'_value').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_register_abilityInstances_'+index+'_value').wrap('<div class="col-md-2"></div>');
        $('#dndrules_monsterbundle_monster_register_abilityInstances_'+index+'_ability').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_register_abilityInstances_'+index+'_ability').wrap('<div class="col-md-4"></div>');
        $('#dndrules_monsterbundle_monster_register_abilityInstances_'+index)
                .append('<div class="col-md-2">\n\
                            <button type="button" class="btn btn-warning" id="sort-abilityinstances-delete-'+index+'">Supp</button>\n\
                        </div>');
        
        $('[id^="monster-abilityinstances-delete"]').on("click", function() {
            removeAbilityInstances($(this));
        });
    }
    
    var containerAbilityInstances = $('div#dndrules_monsterbundle_monster_register_abilityInstances');
                                        $('div#dndrules_monsterbundle_monster_register_abilityInstances').prev().hide();
    var index = containerAbilityInstances.find(':input').length;
    
    $('div#dndrules_monsterbundle_monster_register_abilityInstances')
    .append('<hr />\n\
            <div class="row">\n\
                <div class="col-md-offset-10 col-md-2">\n\
                    <button type="button" class="btn btn-primary btn-block" id="sort-abilityinstances-add">+ Car.</button>\n\
                </div>\n\
            </div>\n\
            <hr />');
    
    $('#sort-abilityinstances-add').on("click", function() {
        addAbilityInstances(containerAbilityInstances, index);
        index++;
    });
    
    $('[id^="sort-abilityinstances-delete"]').on("click", function() {
        removeAbilityInstances($(this));
    });
    
    
    //---- SKILL
    function addContainerSkillInstances(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name).replace(/__name__/g, index)));
    }
    
    function removeSkillInstances(button) {
        button.parent().parent().remove();
    }
    
    function addSkillInstances(container, index) {
        addContainerSkillInstances(container, '', index);
        
        $('#dndrules_monsterbundle_monster_register_skillInstances_'+index+'_ranks').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_register_skillInstances_'+index+'_ranks').wrap('<div class="col-md-2"></div>');
        $('#dndrules_monsterbundle_monster_register_skillInstances_'+index+'_skill').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_register_skillInstances_'+index+'_skill').wrap('<div class="col-md-4"></div>');
        $('#dndrules_monsterbundle_monster_register_skillInstances_'+index)
                .append('<div class="col-md-2">\n\
                            <button type="button" class="btn btn-warning" id="sort-skillinstances-delete-'+index+'">Supp</button>\n\
                        </div>');
        
        $('[id^="monster-skillinstances-delete"]').on("click", function() {
            removeSkillInstances($(this));
        });
    }
    
    var containerSkillInstances = $('div#dndrules_monsterbundle_monster_register_skillInstances');
                                        $('div#dndrules_monsterbundle_monster_register_skillInstances').prev().hide();
    var index = containerSkillInstances.find(':input').length;
    
    $('div#dndrules_monsterbundle_monster_register_skillInstances')
    .append('<hr />\n\
            <div class="row">\n\
                <div class="col-md-offset-10 col-md-2">\n\
                    <button type="button" class="btn btn-primary btn-block" id="sort-skillinstances-add">+ Comp.</button>\n\
                </div>\n\
            </div>\n\
            <hr />');
    
    $('#sort-skillinstances-add').on("click", function() {
        addSkillInstances(containerSkillInstances, index);
        index++;
    });
    
    $('[id^="sort-skillinstances-delete"]').on("click", function() {
        removeSkillInstances($(this));
    });
    
    // --- SpeedSpecial
    function addContainerSpeedSpecialInstances(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name).replace(/__name__/g, index)));
    }
    
    function removeSpeedSpecialInstances(button) {
        button.parent().parent().remove();
    }
    
    function addSpeedSpecialInstances(container, index) {
        addContainerSpeedSpecialInstances(container, '', index);
        
        $('#dndrules_monsterbundle_monster_register_speedSpecialInstances_'+index+'_value').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_register_speedSpecialInstances_'+index+'_value').wrap('<div class="col-md-2"></div>');
        $('#dndrules_monsterbundle_monster_register_speedSpecialInstances_'+index+'_speedSpecial').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_register_speedSpecialInstances_'+index+'_speedSpecial').wrap('<div class="col-md-4"></div>');
        $('#dndrules_monsterbundle_monster_register_speedSpecialInstances_'+index)
                .append('<div class="col-md-2">\n\
                            <button type="button" class="btn btn-warning" id="sort-speedspecialinstances-delete-'+index+'">Supp</button>\n\
                        </div>');
        
        $('[id^="monster-speedspecialinstances-delete"]').on("click", function() {
            removeSpeedSpecialInstances($(this));
        });
    }
    
    var containerSpeedSpecialInstances = $('div#dndrules_monsterbundle_monster_register_speedSpecialInstances');
                                        $('div#dndrules_monsterbundle_monster_register_speedSpecialInstances').prev().hide();
    var index = containerSpeedSpecialInstances.find(':input').length;
    
    $('div#dndrules_monsterbundle_monster_register_speedSpecialInstances')
    .append('<hr />\n\
            <div class="row">\n\
                <div class="col-md-offset-10 col-md-2">\n\
                    <button type="button" class="btn btn-primary btn-block" id="sort-speedspecialinstances-add">+ MD</button>\n\
                </div>\n\
            </div>\n\
            <hr />');
    
    $('#sort-speedspecialinstances-add').on("click", function() {
        addSpeedSpecialInstances(containerSpeedSpecialInstances, index);
        index++;
    });
    
    $('[id^="sort-speedspecialinstances-delete"]').on("click", function() {
        removeSpeedSpecialInstances($(this));
    });
});