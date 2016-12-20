$(document).ready(function() {
    function addPrototypeDomain(container, name, index) {
        container.append($(container.attr('data-prototype').replace(/__name__label__/g, name + ' ' + (index+1)+' :').replace(/__name__/g, index)));
    }
    
    function removeDomain(button) {
        button.parent().parent().parent().remove();
    }
    
    function addDomain(container, index) {
        addPrototypeDomain(container, 'Domaine ', index);
        
        $('#dndrules_sortbundle_sort_register_domains_'+index).parent().addClass('row form-group');
        $('#dndrules_sortbundle_sort_register_domains_'+index).prev().addClass('col-md-3 control-label');
        $('#dndrules_sortbundle_sort_register_domains_'+index).addClass('col-md-9');
               
        $('#dndrules_sortbundle_sort_register_domains_'+index+'_minimumLevel').prev().wrap('<div class="col-md-3 control-label"></div>');
        $('#dndrules_sortbundle_sort_register_domains_'+index+'_minimumLevel').wrap('<div class="col-md-2"></div>');
        $('#dndrules_sortbundle_sort_register_domains_'+index+'_minimumLevel').addClass('form-control');
        $('#dndrules_sortbundle_sort_register_domains_'+index+'_domain').prev().wrap('<div class="col-md-2 control-label"></div>');
        $('#dndrules_sortbundle_sort_register_domains_'+index+'_domain').wrap('<div class="col-md-3"></div>');
        $('#dndrules_sortbundle_sort_register_domains_'+index+'_domain').addClass('form-control');
        $('#dndrules_sortbundle_sort_register_domains_'+index)
                .append('<div class="col-md-2">\n\
                            <button type="button" class="btn btn-warning" id="sort-domains-delette-'+index+'">Supp</button>\n\
                        </div>');
        
        $('[id^="sort-domains-delette"]').on("click", function() {
            removeDomain($(this));
        });
    }
    
    var container_domains = $('div#dndrules_sortbundle_sort_register_domains');
                            $('div#dndrules_sortbundle_sort_register_domains').prev().hide();
                            
    var index = container_domains.find(':input').length;
    
    $('div#dndrules_sortbundle_sort_register_domains')
    .append('<hr />\n\
            <div class="row">\n\
                <div class="col-md-offset-10 col-md-2">\n\
                    <button type="button" class="btn btn-primary btn-block" id="sort-domains-add">+ Domaine</button>\n\
                </div>\n\
            </div>\n\
            <hr />');
    
    if (index === 0) {
        addDomain(container_domains, index);
        index++;
    }
    
    $('#sort-domains-add').on("click", function() {
        addDomain(container_domains, index);
        index++;
    });
    
    $('[id^="sort-domains-delette"]').on("click", function() {
        removeDomain($(this));
    });
});