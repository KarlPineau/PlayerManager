$(document).ready(function() {
    function addPrototype(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name + ' ' + (index+1)+' :').replace(/__name__/g, index)));
    }
    
    function removeClass(button) {
        button.parent().parent().parent().remove();
    }
    
    function addClass(container, index) {
        addPrototype(container, 'Classe ', index);
        
        $('#dndrules_sortbundle_sort_register_classes_'+index).parent().addClass('row form-group');
        $('#dndrules_sortbundle_sort_register_classes_'+index).prev().addClass('col-md-3 control-label');
        $('#dndrules_sortbundle_sort_register_classes_'+index).addClass('col-md-9');
               
        $('#dndrules_sortbundle_sort_register_classes_'+index+'_minimumLevel').prev().wrap('<div class="col-md-3 control-label"></div>');
        $('#dndrules_sortbundle_sort_register_classes_'+index+'_minimumLevel').wrap('<div class="col-md-2"></div>');
        $('#dndrules_sortbundle_sort_register_classes_'+index+'_minimumLevel').addClass('form-control');
        $('#dndrules_sortbundle_sort_register_classes_'+index+'_classdnd').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_sortbundle_sort_register_classes_'+index+'_classdnd').wrap('<div class="col-md-3"></div>');
        $('#dndrules_sortbundle_sort_register_classes_'+index+'_classdnd').addClass('form-control');
        $('#dndrules_sortbundle_sort_register_classes_'+index)
                .append('<div class="col-md-2">\n\
                            <button type="button" class="btn btn-warning" id="sort-classes-delete-'+index+'">Supp</button>\n\
                        </div>');
        
        $('[id^="sort-classes-delete"]').on("click", function() {
            removeClass($(this));
        });
    }
    
    var container_classes = $('div#dndrules_sortbundle_sort_register_classes');
                            $('div#dndrules_sortbundle_sort_register_classes').prev().hide();
                            
    var index = container_classes.find(':input').length;
    
    $('div#dndrules_sortbundle_sort_register_classes')
    .append('<hr />\n\
            <div class="row">\n\
                <div class="col-md-offset-10 col-md-2">\n\
                    <button type="button" class="btn btn-primary btn-block" id="sort-classes-add">+ Classe</button>\n\
                </div>\n\
            </div>\n\
            <hr />');
    
    if (index === 0) {
        addClass(container_classes, index);
        index++;
    }
    
    $('#sort-classes-add').on("click", function() {
        addClass(container_classes, index);
        index++;
    });
    
    $('[id^="sort-classes-delete"]').on("click", function() {
        removeClass($(this));
    });
});