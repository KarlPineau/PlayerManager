$(document).ready(function() {
    $.each($('div[id^="dndinstance_characterbundle_characterused_addskill_skills_"]'), function() {
        var id = $(this).attr('id');
        var index = $(this).prev().text();
        var skill = $(this).children().first().html();
        var level = $(this).children().last().html();

        $(this).parent().replaceWith('' +
            '<tr id="'+id+'">' +
            '   <td>'+index+'</td>' +
            '   <td>'+skill+'</td>' +
            '   <td>'+level+'</td>' +
            '</tr>');

        $('#dndinstance_characterbundle_characterused_addskill_skills_'+index+'_skill').prev().hide();
        $('#dndinstance_characterbundle_characterused_addskill_skills_'+index+'_skill').addClass('form-control').css('color', '#000').css('font-weight', '700');
        $('#dndinstance_characterbundle_characterused_addskill_skills_'+index+'_ranks').prev().hide();
        $('#dndinstance_characterbundle_characterused_addskill_skills_'+index+'_ranks').addClass('form-control');
    });

    var content = $('#dndinstance_characterbundle_characterused_addskill_skills').html();

    $('#dndinstance_characterbundle_characterused_addskill_skills').html('' +
        '<table class="table table-bordered table-striped">' +
        '   <thead>' +
        '       <tr>' +
        '           <th>#</th>' +
        '           <th>Compétence</th>' +
        '           <th>Niveau</th>' +
        '       </tr>' +
        '   </thead>' +
        '   <tbody>'+content+'</tbody>' +
        '</table>');
});