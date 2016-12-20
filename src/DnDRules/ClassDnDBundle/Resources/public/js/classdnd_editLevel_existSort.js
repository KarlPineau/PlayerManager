function existSort(containerSort, indexSort, index) {
    if(indexSort === 0) {
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort).prev().remove();
        var classSortHTML = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort).html();
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort).parent().replaceWith('<table id="table-sorts-'+index+'"><tr><td><table id="dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'"><tr></tr></table></td></tr></table>');
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+' > tbody > tr').html(classSortHTML);

        //Ajout du bouton Ajout pour les BABs
        $('#table-sorts-'+index+' > tbody > tr')
            .append('<td>\n\
                        <button type="button" class="btn btn-primary" id="classdnd-levels-sorts-add-'+index+'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>\n\
                    </td>');
            $('#classdnd-levels-sorts-add-'+index).on("click", function() {
                indexSort++;
                addSort(containerSort, indexSort, index);
            });
    } else {
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort).prev().remove();
        var classSortHTML = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort).html();
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort).parent().replaceWith('<table id="dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'"><tr></tr></table>');
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+' > tbody > tr').html(classSortHTML);
    }

    /* Value : */
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'_sortLevel').prev().text('Niveau').remove();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'_sortLevel').addClass('form-control');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'_sortLevel').parent().wrap('<td></td>');

    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'_maximumUsedSorts').prev().remove();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'_maximumUsedSorts').addClass('form-control');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'_maximumUsedSorts').parent().wrap('<td></td>');

    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'_maximumKnownSorts').prev().remove();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'_maximumKnownSorts').addClass('form-control');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+'_maximumKnownSorts').parent().wrap('<td></td>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts_'+indexSort+' > tbody > tr')
            .append('<td>\n\
                        <button type="button" class="btn btn-warning" id="classdnd-levels-sorts-delete-'+indexSort+'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>\n\
                    </td>');

    $('[id^="classdnd-levels-sorts-delete"]').on("click", function() {
        $(this).parent().parent().remove();
        return false;
    });
}