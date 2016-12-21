/**
 * Created by karlpineau on 21/12/2016.
 */
$(document).ready(function() {
    function addPrototype(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, '').replace(/__name__/g, index)));
    }

    function addST(container, index) {
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
            $(this).children().eq(1).children().first().remove();
            $(this).children().last().children().first().remove();
            var input1 = $(this).children().first().html();
            var input2 = $(this).children().eq(1).html();
            var input3 = $(this).children().last().html();

            newDOMInside += '' +
                '<tr id="'+idSub+'">' +
                '   <td>'+input1+'</td>' +
                '   <td>'+input2+'</td>' +
                '   <td>'+input3+'</td>' +
                '</tr>';
        });

        item.html('' +
            '<table>' +
            '   <thead>' +
            '       <tr>' +
            '           <th>Réflexe</th>' +
            '           <th>Vigueur</th>' +
            '           <th>Volonté</th>' +
            '       </tr>' +
            '   </thead>' +
            '   <tbody>'+
                newDOMInside +
            '   </tbody>'+
            '</table>');
    }

    var newDom = '';
    $.each($('#dndrules_classdndbundle_classDnD_register_levels').children(), function() {
        var id = $(this).children().last().attr('id');
        var numId = parseInt(id.replace('dndrules_classdndbundle_classDnD_register_levels_', ''));

        $('#'+id).children().first().children().first().remove();
        var select = $('#'+id).children().first().html();

        $('#'+id).children().last().children().first().remove();
        var generateST = $('#'+id).children().last().html();

        newDom += '' +
            '<tr id="'+id+'">' +
            '   <td>'+select+'</td>' +
            '   <td>'+generateST+'</td>' +
            '</tr>';
    });

    $('#dndrules_classdndbundle_classDnD_register_levels').html('' +
        '<table class="table table-bordered table-strpied">' +
        '   <thead>' +
        '       <tr>' +
        '           <th>Niveau</th>' +
        '           <th>STs</th>' +
        '       </tr>' +
        '   </thead>' +
        '   <tbody>' +
                newDom +
        '   </tbody>' +
        '</table>');

    $.each($('div[id$="_classST"]'), function() {
        if($(this).children().length > 0) {
            $.each($(this).children(), function() {
                format($(this));
            });
        } else {
            addST($(this), 0);
        }
    });
});