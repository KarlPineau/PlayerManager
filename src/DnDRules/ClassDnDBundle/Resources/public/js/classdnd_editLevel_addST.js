function addPrototypeST(container) {
    var containerOrigin = container.attr('data-prototype');
    var containerNew = $(container.attr('data-prototype'));
    container.attr('data-prototype', containerOrigin);
    container.append(containerNew);
}

function addST(container, index) {
    addPrototypeST(container);

    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index).prev().remove();
    var classSTHTML = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index).html();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index).parent().replaceWith('<table id="dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'"><tr></tr></table>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+' > tbody > tr').html(classSTHTML);

    /* ST : */
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'_fortitude').prev().text('Réflexe').remove();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'_fortitude').parent().wrap('<td></td>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'_fortitude').addClass('form-control');

    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'_reflex').prev().text('Vigueur').hide();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'_reflex').parent().wrap('<td></td>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'_reflex').addClass('form-control');

    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'_will').prev().text('Volonté').hide();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'_will').parent().wrap('<td></td>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_'+index+'_will').addClass('form-control');
}