$(document).ready(function() {
    var container_levels = $('div#dndrules_classdndbundle_classDnD_edit_levels');
                           $('div#dndrules_classdndbundle_classDnD_edit_levels').prev().hide();
                            
    var nbLevels = $('div#dndrules_classdndbundle_classDnD_edit_levels > div > div[id^="dndrules_classdndbundle_classDnD_edit_levels_"]').length;
    
    $('div#dndrules_classdndbundle_classDnD_edit_levels')
    .append('<hr />\n\
            <div class="row">\n\
                <div class="col-md-offset-10 col-md-2">\n\
                    <button type="button" class="btn btn-primary btn-block" id="classdnd-levels-add">+ Level</button>\n\
                </div>\n\
            </div>\n\
            <hr />\n\
            <table class="table" id="dndrules_classdndbundle_classDnD_edit_levels_table">\n\
                <tr>\n\
                    <th rowspan="2">Niveau</th>\n\
                    <th colspan="3">ST</th>\n\
                    <th colspan="4">BAB</th>\n\
                    <th colspan="5">Sorts</th>\n\
                    <th rowspan="2">#</th>\n\
                </tr>\n\
                <tr>\n\
                    <th>Réflexe</th>\n\
                    <th>Vigueur</th>\n\
                    <th>Volonté</th>\n\
                    <th>N° Attaque</th>\n\
                    <th>Valeur</th>\n\
                    <th>#</th>\n\
                    <th>+</th>\n\
                    <th>Niv</th>\n\
                    <th>Connus</th>\n\
                    <th>Max/j</th>\n\
                    <th>#</th>\n\
                    <th>+</th>\n\
                </tr>');
    $('#classdnd-levels-add').on("click", function() {
        var nbLevelsPresents = $('table#dndrules_classdndbundle_classDnD_edit_levels_table > tbody > tr[id^="dndrules_classdndbundle_classDnD_edit_levels_"]').length;
        addLevel(container_levels, nbLevelsPresents);
    });
    
    if (nbLevels === 0) {
        addLevel(container_levels, 0);
    } else {
        existLevel(nbLevels);
    }
    
    $('[id^="classdnd-levels-delete"]').on("click", function() {
        $(this).parent().parent().parent().remove();
        return false;
    });
    
    $('div#dndrules_classdndbundle_classDnD_edit_levels')
    .append('</table>');
});