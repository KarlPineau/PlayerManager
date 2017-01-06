$(document).ready(function() {
    function addContainerAbilityInstances(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name).replace(/__name__/g, index)));
    }
    
    function addAbilityInstances(container, index) {
        addContainerAbilityInstances(container, '', index);
        format(index);

    }

    function format(index) {
        if($('#dndrules_monsterbundle_monster_abilities_abilityInstances_'+index).prev().is('label')) {
            $('#dndrules_monsterbundle_monster_abilities_abilityInstances_'+index).prev().hide();
        }
        $('#dndrules_monsterbundle_monster_abilities_abilityInstances_'+index+'_value').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_abilities_abilityInstances_'+index+'_value').wrap('<div class="col-md-2"></div>');
        $('#dndrules_monsterbundle_monster_abilities_abilityInstances_'+index+'_ability').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_abilities_abilityInstances_'+index+'_ability').wrap('<div class="col-md-4"></div>');
        $('#dndrules_monsterbundle_monster_abilities_abilityInstances_'+index)
            .append('<div class="col-md-2">\n\
                            <button type="button" class="btn btn-warning" id="btn-remove-dndrules_monsterbundle_monster_abilities_abilityInstances-'+index+'">Supp</button>\n\
                        </div>');

        $('#btn-remove-dndrules_monsterbundle_monster_abilities_abilityInstances-'+index).on("click", function() {
            $(this).parent().parent().parent().remove();
        });
    }
    
    var containerAbilityInstances = $('div#dndrules_monsterbundle_monster_abilities_abilityInstances');
    var index = containerAbilityInstances.find(':input').length;

    $.each($('div[id^="dndrules_monsterbundle_monster_abilities_abilityInstances_"]'), function() {
        var idDiv = $(this).attr('id').replace('dndrules_monsterbundle_monster_abilities_abilityInstances_', '');
        format(idDiv);
    });
    
    $('div#dndrules_monsterbundle_monster_abilities_abilityInstances')
    .prepend(''+
            '<div class="row">'+
            '    <div class="col-md-offset-10 col-md-2">'+
            '        <button type="button" class="btn btn-primary btn-block" id="sort-abilityinstances-add">+ Car.</button>'+
            '    </div>'+
            '</div>');
    
    $('#sort-abilityinstances-add').on("click", function() {
        addAbilityInstances(containerAbilityInstances, index);
        index++;
    });
    
    $('[id^="sort-abilityinstances-delete"]').on("click", function() {
        removeAbilityInstances($(this));
    });
});