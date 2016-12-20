function existBAB(containerBAB, indexBAB, index) {
    if(indexBAB === 0) {
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB).prev().remove();
        var classBABHTML = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB).html();
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB).parent().replaceWith('<table id="table-babs-'+index+'"><tr><td><table id="dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+'"><tr></tr></table></td></tr></table>');
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+' > tbody > tr').html(classBABHTML);

        //Ajout du bouton Ajout pour les BABs
        $('#table-babs-'+index+' > tbody > tr')
            .append('<td>\n\
                        <button type="button" class="btn btn-primary" id="classdnd-levels-babs-add-'+index+'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>\n\
                    </td>');
            $('#classdnd-levels-babs-add-'+index).on("click", function() {
                ++indexBAB;
                addBAB(containerBAB, indexBAB, index);
            });
            
    } else {
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB).prev().remove();
        var classBABHTML = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB).html();
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB).parent().replaceWith('<table id="dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+'"><tr></tr></table>');
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+' > tbody > tr').html(classBABHTML);
    }

    /* Value : */
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+'_attackNb').prev().remove();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+'_attackNb').parent().wrap('<td></td>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+'_attackNb').addClass('form-control');

    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+'_value').prev().remove();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+'_value').parent().wrap('<td></td>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+'_value').addClass('form-control');

    //Ajout du bouton de suppression :
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs_'+indexBAB+' > tbody > tr').append('<td>\n\
                        <button type="button" class="btn btn-warning" id="classdnd-levels-babs-delete-'+indexBAB+'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>\n\
                     </td>');
    $('[id^="classdnd-levels-babs-delete"]').on("click", function() {
        $(this).parent().parent().remove();
        return false;
    });
}