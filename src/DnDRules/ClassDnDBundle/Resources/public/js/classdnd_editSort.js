/**
 * Created by karlpineau on 21/12/2016.
 */
$(document).ready(function() {
    function addPrototype(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, '').replace(/__name__/g, index)));
    }

    function addSort(container, index) {
        addPrototype(container, '', index);
        format(container.children().last());
    }

    function format(item) {
        $.each($('input,select'), function() {
            if(!$(this).hasClass("form-control")) {
                $(this).addClass('form-control');
            }
        });

        item.children().first().remove();
        var newDOMInside = '';

        $.each(item.children(), function() {
            var idSub = $(this).attr('id');
            $(this).children().first().children().first().remove();
            $(this).children().last().children().first().remove();
            var input1 = $(this).children().first().html();
            var input2 = $(this).children().last().html();

            newDOMInside += '' +
                '<tr id="'+idSub+'">' +
                '   <td>'+input1+'</td>' +
                '   <td>'+input2+'</td>' +
                '   <td><button class="btn btn-danger remove-line" attr-id="'+idSub+'" type="button"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
        });

        item.html('' +
            '<table>' +
            '   <thead>' +
            '       <tr>' +
            '           <th>Index</th>' +
            '           <th>Valeur</th>' +
            '           <th>#</th>' +
            '       </tr>' +
            '   </thead>' +
            '   <tbody>'+
                newDOMInside +
            '   </tbody>'+
            '</table>');
        
        $.each($('.remove-line'), function() {
            $(this).on('click', function() {
                $('#'+$(this).attr('attr-id')).parent().parent().parent().remove();
            });
        });
    }

    var newDom = '';
    $.each($('#dndrules_classdndbundle_classDnD_register_levels').children(), function() {
        var id = $(this).children().last().attr('id');
        var numId = parseInt(id.replace('dndrules_classdndbundle_classDnD_register_levels_', ''));

        $('#'+id).children().first().children().first().remove();
        var select = $('#'+id).children().first().html();

        $('#'+id).children().last().children().first().remove();
        var generateSort = $('#'+id).children().last().html();

        newDom += '' +
            '<tr id="'+id+'">' +
            '   <td>'+select+'</td>' +
            '   <td>'+generateSort+'</td>' +
            '   <td><button class="btn btn-primary add-line" attr-id="'+id+'" type="button"><i class="fa fa-plus"></i></button></td>' +
            '</tr>';
    });

    $('#dndrules_classdndbundle_classDnD_register_levels').html('' +
        '<table class="table table-bordered table-strpied">' +
        '   <thead>' +
        '       <tr>' +
        '           <th>Niveau</th>' +
        '           <th>Sorts</th>' +
        '           <th>Add</th>' +
        '       </tr>' +
        '   </thead>' +
        '   <tbody>' +
                newDom +
        '   </tbody>' +
        '</table>');

    $.each($('div[id$="_classSorts"]'), function() {
        $.each($(this).children(), function() {
            format($(this));
        });
    });

    $.each($('.add-line'), function() {
        $(this).on('click', function() {
            if($('#'+$(this).attr('attr-id')+'_classSorts').children().length > 0) {
                var idclassSorts = $('#' + $(this).attr('attr-id') + '_classSorts').children().last().children().first().children().last().children().first().attr('id');
                var intToIncre = parseInt(idclassSorts.substr(idclassSorts.length - 1));
            } else { intToIncre = -1; }

            addSort($('#'+$(this).attr('attr-id')+'_classSorts'), (intToIncre+1));
        });
    });

    $.each($('.remove-line'), function() {
        $(this).on('click', function() {
            $('#'+$(this).attr('attr-id')).parent().parent().parent().remove();
        });
    });
});