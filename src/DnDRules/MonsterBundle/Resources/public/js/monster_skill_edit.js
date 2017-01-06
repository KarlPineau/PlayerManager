$(document).ready(function() {
    function addContainerSkillInstances(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name).replace(/__name__/g, index)));
    }
    
    function addSkillInstances(container, index) {
        addContainerSkillInstances(container, '', index);
        format(index);
    }

    function format(index) {
        if($('#dndrules_monsterbundle_monster_skills_skillInstances_'+index).prev().is('label')) {
            $('#dndrules_monsterbundle_monster_skills_skillInstances_'+index).prev().hide();
        }
        $('#dndrules_monsterbundle_monster_skills_skillInstances_'+index+'_ranks').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_skills_skillInstances_'+index+'_ranks').wrap('<div class="col-md-2"></div>');
        $('#dndrules_monsterbundle_monster_skills_skillInstances_'+index+'_skill').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_monsterbundle_monster_skills_skillInstances_'+index+'_skill').wrap('<div class="col-md-4"></div>');
        $('#dndrules_monsterbundle_monster_skills_skillInstances_'+index)
            .append('' +
                '<div class="col-md-2">'+
                '   <button type="button" class="btn btn-warning" id="btn-remove-dndrules_monsterbundle_monster_skills_skillInstances-'+index+'">Supp</button>'+
                '</div>');

        $('#btn-remove-dndrules_monsterbundle_monster_skills_skillInstances-'+index).on("click", function() {
            $(this).parent().parent().parent().remove();
        });
    }
    
    var containerSkillInstances = $('div#dndrules_monsterbundle_monster_skills_skillInstances');
    var index = containerSkillInstances.find(':input').length;

    $.each($('div[id^="dndrules_monsterbundle_monster_skills_skillInstances_"]'), function() {
        var idDiv = $(this).attr('id').replace('dndrules_monsterbundle_monster_skills_skillInstances_', '');
        format(idDiv);
    });
    
    $('div#dndrules_monsterbundle_monster_skills_skillInstances')
    .prepend(''+
            '<div class="row">'+
            '    <div class="col-md-offset-10 col-md-2">'+
            '        <button type="button" class="btn btn-primary btn-block" id="sort-skillinstances-add"><i class="fa fa-plus"></i> Compétence</button>'+
            '    </div>'+
            '</div>');
    
    $('#sort-skillinstances-add').on("click", function() {
        addSkillInstances(containerSkillInstances, index);
        index++;
    });
    
    $('[id^="sort-skillinstances-delete"]').on("click", function() {
        removeSkillInstances($(this));
    });
});