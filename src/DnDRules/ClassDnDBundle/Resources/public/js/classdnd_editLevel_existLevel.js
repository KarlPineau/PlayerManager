function existLevel(i) {
    for(var index = 0; index < i; index++) {
        //Création du TR
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index).prev().remove(); //Supp label
        var levelHtml = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'').html();
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index).parent().remove();
        $('#dndrules_classdndbundle_classDnD_edit_levels_table > tbody').append('<tr id="dndrules_classdndbundle_classDnD_edit_levels_'+index+'"></tr>');
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index).html(levelHtml);

        //Ajout du champ Niveau
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_level').prev().remove();
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_level').parent().wrap('<td></td>');
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_level').addClass('form-control');
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_level > option[value="'+(index+1)+'"]').attr('selected', 'selected');

        /* Class ST */
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST').prev().remove();
        var classStHtml = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST').parent().html();
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST').parent().replaceWith('<td colspan="3">'+classStHtml+'</td>');
                           $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST').prev().hide();
        for(var indexST = 0; indexST < 1; indexST++) {
            existST(index);
        }

        /* Class BABs */
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs').prev().remove();
        var classBabHtml = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs').parent().html();
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs').parent().replaceWith('<td colspan="4">'+classBabHtml+'</td>');
        var container_BAB = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs');
                            $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs').prev().hide();
        var iBAB = container_BAB.find(':input').length;
        for(var indexBAB = 0; indexBAB < iBAB; indexBAB++) {
            existBAB(container_BAB, indexBAB, index);
        }

        /* Class Sorts */
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts').prev().remove();
        var classSortHtml = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts').parent().html();
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts').parent().replaceWith('<td colspan="4">'+classSortHtml+'</td>');
        var container_Sort = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts');
                             $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts').prev().hide();
        var iSort = container_Sort.find(':input').length;
        for(var indexSort = 0; indexSort < iSort; indexSort++) {
            existSort(container_Sort, indexSort, index);
        }

        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index)
        .append('<td>\n\
                    <button type="button" class="btn btn-warning" id="classdnd-levels-delete-'+index+'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>\n\
                </td>');
        $('#classdnd-levels-delete-'+index).on("click", function() {
            $(this).parent().parent().remove();
            return false;
        });
    }
}