$(document).ready(function() {
    var index = $('div[id^="dndinstance_characterbundle_characterused_edit_classDnDInstances_"]').prev().text(),
        select_class = $('select#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_classDnD').html(),
        select_level = $('select#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_level').html();

    $('div#dndinstance_characterbundle_characterused_edit_classDnDInstances').prev().hide();
    $('div[id^="dndinstance_characterbundle_characterused_edit_classDnDInstances_"]').prev().hide();
    $('div[id^="dndinstance_characterbundle_characterused_edit_classDnDInstances_"]').html('\n\
            <div class="col-md-3 control-label">\n\
                <label class="control-label required" for="dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_classDnD">Classe :</label>\n\
            </div>\n\
            <div class="col-md-9">\n\
                <div class="row">\n\
                    <div class="col-md-5">\n\
                        <select id="dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_classDnD" class="required form-control" name="dndinstance_characterbundle_characterused_edit[classDnDInstances][' + index + '][classDnD]">\n\
                        ' + select_class + '\n\
                        </select>\n\
                    </div>\n\
                    <div class="col-md-3 control-label">\n\
                        <label class="control-label required" for="dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_level">Niveau :</label>\n\
                    </div>\n\
                    <div class="col-md-4">\n\
                        <select id="dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_level" class="required form-control" name="dndinstance_characterbundle_characterused_edit[classDnDInstances][' + index + '][level]">\n\
                        ' + select_level + '\
                        </select>\n\
                    </div>\n\
                </div>\n\
            </div>');
    
    
});