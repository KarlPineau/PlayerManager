function existST(index) {
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0').prev().remove();
    var classSTHTMLExist = $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0').html();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0').parent().replaceWith('<table id="dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0"><tbody><tr></tr></tbody></table>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0 > tbody > tr').html(classSTHTMLExist);

    /* ST : */
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0_fortitude').prev().remove();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0_fortitude').parent().wrap('<td></td>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0_fortitude').addClass('form-control');

    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0_reflex').prev().remove();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0_reflex').parent().wrap('<td></td>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0_reflex').addClass('form-control');

    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0_will').prev().remove();
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0_will').parent().wrap('<td></td>');
    $('#dndrules_classdndbundle_classDnD_edit_levels_'+index+'_classST_0_will').addClass('form-control');
}