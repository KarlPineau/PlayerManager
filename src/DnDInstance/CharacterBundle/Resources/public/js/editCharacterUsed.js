$(document).ready(function() {
    function addPrototype(container, index) {
        container.append(container.attr('data-prototype')
            .replace(/__name__label__/g, 'Classe n°' + (index+1))
            .replace(/__name__/g, index));
    }
    function addClassDnD(container) {
        addPrototype(container, index);
        formatClassDnD(index);

    }
    function formatClassDnD(index) {
        $('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index).prev().hide();
        $('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_classDnD').prev().text($('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_classDnD').prev().text()+' :');
        $('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_classDnD').prev().wrap('<div class="col-md-3 control-label"></div>');
        $('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_classDnD').wrap('<div class="col-md-4"></div>');
        $('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_classDnD').addClass('form-control');
        $('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_level').prev().text($('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_level').prev().text()+' :');
        $('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_level').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_level').wrap('<div class="col-md-3"></div>');
        $('#dndinstance_characterbundle_characterused_edit_classDnDInstances_' + index + '_level').addClass('form-control');
    }

    var container = $('#dndinstance_characterbundle_characterused_edit_classDnDInstances');
                    $('#dndinstance_characterbundle_characterused_edit_classDnDInstances').prev().hide();

    var index = container.children().length;
    if(index == 0) {
        addClassDnD(container);
        index++;
    } else {
        $.each(container.children(), function() {
            formatClassDnD($(this).index());
        });
    }
});