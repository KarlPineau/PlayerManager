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
        $('#dndrules_race_race_skills_raceSkills_' + index).prev().hide();
        $('#dndrules_race_race_skills_raceSkills_' + index + '_skill').prev().wrap('<div class="col-sm-2 control-label"></div>');
        $('#dndrules_race_race_skills_raceSkills_' + index + '_skill').wrap('<div class="col-sm-4"></div>');
        $('#dndrules_race_race_skills_raceSkills_' + index + '_skill').addClass('form-control');
        $('#dndrules_race_race_skills_raceSkills_' + index + '_value').prev().wrap('<div class="col-sm-2 control-label"></div>');
        $('#dndrules_race_race_skills_raceSkills_' + index + '_value').wrap('<div class="col-sm-3"></div>');
        $('#dndrules_race_race_skills_raceSkills_' + index + '_value').addClass('form-control');
        
        $('#dndrules_race_race_skills_raceSkills_' + index).append('' +
            '<div class="col-sm-1">' +
            '   <button class="btn btn-warning" type="button" id="remove-'+index+'"><i class="fa fa-remove"></i></button>' +
            '</div>');
        $('#remove-'+index).on('click', function() {
            $(this).parent().parent().parent().remove();
        });
    }

    var container = $('#dndrules_race_race_skills_raceSkills');
                    //$('#dndrules_race_race_skills_raceSkills').prev().hide();

    var index = container.children().length;
    if(index > 0) {
        $.each(container.children(), function() {
            formatSkill($(this).index());
        });
    }

    $('#dndrules_race_race_skills_raceSkills').before('' +
        '<div class="text-right">' +
        '   <button type="button" class="btn btn-primary" id="addSkill"><i class="fa fa-plus"></i></button>' +
        '</div>');
    $('#addSkill').on('click', function() {addSkill(container, index); index++;});
});