function addSortPrototype(container, indexSort) {
    if(indexSort === 0)
    {
        var containerOrigin = container.attr('data-prototype').replace(/_classSorts_\d+/g, '_classSorts___name__');
        container.attr('data-prototype', containerOrigin);
    } 
    container.append(container.attr('data-prototype').replace(/__name__/g, indexSort));
}

function addSort(containerSort, indexSort, index) {
    addSortPrototype(containerSort, indexSort);

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
        var newContent = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts > div').html().replace(/_classSorts_0/g, '_classSorts_'+indexSort).replace(/[classSorts][0]/g, '[classSorts]['+indexSort+']');
        $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classSorts > div').html(newContent);
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