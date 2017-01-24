$(document).ready(function() {
    function addPrototype(container, index) {
        container.append(container.attr('data-prototype')
            .replace(/__name__label__/g, 'Spécificité n°' + (index+1))
            .replace(/__name__/g, index));
    }
    function addSpecificity(container, index) {
        addPrototype(container, index);
        formatSpecificity(index);

    }
    function formatSpecificity(index) {
        if(index > 0) {
            $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index).prepend('<hr />');
        }
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index).prev().hide();
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_title').parent().addClass('row form-group');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_title').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_title').wrap('<div class="col-sm-9"></div>');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_title').addClass('form-control');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_description').parent().addClass('row form-group');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_description').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_description').wrap('<div class="col-sm-9"></div>');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_description').addClass('form-control');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_levelMin').parent().addClass('row form-group');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_levelMin').prev().wrap('<div class="col-sm-3 control-label"></div>');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_levelMin').wrap('<div class="col-sm-8"></div>');
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_levelMin').addClass('form-control');
        
        $('#dndrules_classdndbundle_classspecificities_classSpecificities_' + index + '_levelMin').parent().parent().append('' +
            '<div class="col-sm-1">' +
            '   <button class="btn btn-warning" type="button" id="remove-'+index+'"><i class="fa fa-remove"></i></button>' +
            '</div>');
        $('#remove-'+index).on('click', function() {
            $(this).parent().parent().parent().remove();
        });
    }

    var container = $('#dndrules_classdndbundle_classspecificities_classSpecificities');
                    //$('#dndrules_classdndbundle_classspecificities_classSpecificities').prev().hide();

    var index = container.children().length;
    if(index > 0) {
        $.each(container.children(), function() {
            formatSpecificity($(this).index());
        });
    }

    $('#dndrules_classdndbundle_classspecificities_classSpecificities').before('' +
        '<div class="text-right">' +
        '   <button type="button" class="btn btn-primary" id="addSpecificity"><i class="fa fa-plus"></i></button>' +
        '</div>');
    $('#addSpecificity').on('click', function() {addSpecificity(container, index); index++;});
});