function addPrototypeLevel(container, index) {
    $('#dndrules_classdndbundle_classDnD_edit_levels_table > tbody').append(container.attr('data-prototype').replace(/__name__label__/g, ' Niveau :').replace(/__name__/g, index));
}

function addLevel(container, index) {
    addPrototypeLevel(container,  index);
    
    //Création du TR
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index).prev().remove(); //Supp label
    var levelHtml = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'').html();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index).parent().replaceWith('<tr id="dndrules_classdndbundle_classDnD_edit_levels_'+index+'"></tr>');
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
    var container_ST = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST');
                       $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST').prev().hide();
    var indexST = container_ST.find(':input').length;
    if (indexST === 0) {
        addST(container_ST, index);
    }

    /* Class BABs */
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs').prev().remove();
    var classBabHtml = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs').parent().html();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs').parent().replaceWith('<td colspan="4">'+classBabHtml+'</td>');
    var container_BAB = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs');
                        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classBABs').prev().hide();
    var indexBAB = container_BAB.find(':input').length;
    if (indexBAB === 0) {
        addBAB(container_BAB, indexBAB, index);
    }

    /* Class Sorts */
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts').prev().remove();
    var classSortHtml = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts').parent().html();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts').parent().replaceWith('<td colspan="4">'+classSortHtml+'</td>');
    var container_Sort = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts');
                         $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts').prev().hide();
    var indexSort = container_Sort.find(':input').length;
    if (indexSort === 0) {
        addSort(container_Sort, indexSort, index);
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