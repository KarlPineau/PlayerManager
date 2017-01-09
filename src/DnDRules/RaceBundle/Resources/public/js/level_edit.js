$(document).ready(function() {
    function addPrototype(container, index) {
        container.append(container.attr('data-prototype')
            .replace(/__name__label__/g, 'Compétence n°' + (index+1))
            .replace(/__name__/g, index));
    }
    function addSkill(container, index) {
        addPrototype(container, index);
        formatSkill(index);

    }
    function formatSkill(index) {
        $('#dndrules_race_race_levels_raceLevels_' + index).prev().hide();
        $('#dndrules_race_race_levels_raceLevels_' + index).addClass('row');
        $('#dndrules_race_race_levels_raceLevels_' + index + '_level').prev().wrap('<div class="col-sm-1 control-label"></div>');
        $('#dndrules_race_race_levels_raceLevels_' + index + '_level').wrap('<div class="col-sm-2"></div>');
        $('#dndrules_race_race_levels_raceLevels_' + index + '_level').addClass('form-control');
        $('#dndrules_race_race_levels_raceLevels_' + index + '_gift').prev().wrap('<div class="col-sm-2 control-label"></div>');
        $('#dndrules_race_race_levels_raceLevels_' + index + '_gift').wrap('<div class="col-sm-2"></div>');
        $('#dndrules_race_race_levels_raceLevels_' + index + '_gift').addClass('form-control');
        $('#dndrules_race_race_levels_raceLevels_' + index + '_additionalSkillPoints').prev().wrap('<div class="col-sm-2 control-label"></div>');
        $('#dndrules_race_race_levels_raceLevels_' + index + '_additionalSkillPoints').wrap('<div class="col-sm-2"></div>');
        $('#dndrules_race_race_levels_raceLevels_' + index + '_additionalSkillPoints').addClass('form-control');
        
        $('#dndrules_race_race_levels_raceLevels_' + index).append('' +
            '<div class="col-sm-1">' +
            '   <button class="btn btn-warning" type="button" id="remove-'+index+'"><i class="fa fa-remove"></i></button>' +
            '</div>');
        $('#remove-'+index).on('click', function() {
            $(this).parent().parent().parent().remove();
        });
    }

    var container = $('#dndrules_race_race_levels_raceLevels');

    var index = container.children().length;
    if(index > 0) {
        $.each(container.children(), function() {
            formatSkill($(this).index());
        });
    }

    $('#dndrules_race_race_levels_raceLevels').before('' +
        '<div class="text-right">' +
        '   <button type="button" class="btn btn-primary" id="addSkill"><i class="fa fa-plus"></i></button>' +
        '</div>');
    $('#addSkill').on('click', function() {addSkill(container, index); index++;});
});