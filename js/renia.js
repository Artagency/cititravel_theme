    $( function() {
     $('.close-trip-direction-hld').on('click', function(){   
         var i = 0;
         var regions = [];
         var list = '';
          $.each($('input[name="regions[]"]:checked'), function() {
              i++;
              if(i==1) list += $(this).parent().parent().find('span').html();
              regions.push($(this).val());
          });
          if(i>1) {
              list += ' (...)';
          }
          if(i==0) list = 'kierunek podróży';
          $('input.trip-direction').val(list);
          $('input[name="trp_destination"]').val(regions.join(','));
       });
      });
    
    $('.add-to-hanging').on('click', function() {
        var $this = $(this);

        $.ajax({
            url: $(this).attr('href'),
            data: {action: 'schowek', id: $(this).attr('data-offer-id')},
            type: 'post',
            success: function(result) {
                //result powinien być równy 1
                if(result == 1) {
                  $this.parent().append('<div class="tooltip"><span>Wycieczka dodana do schowka</span><br/><span>Przejdź do <a href="http://cititravel.pl/schowek/">schowka</a></span></div>');
                } else {
                  $this.parent().append('<div class="tooltip"><span>Wycieczka znajduje się już w schowku</span><br/><span>Przejdź do <a href="http://cititravel.pl/schowek/">schowka</a></span></div>');
                }
            }
        });
        return false;
    });

    $('.remove-from-hanging').on('click', function() {
        var container = $(this).parent().parent();
        var type = $(this).attr('data-type');
        $.ajax({
            url: $(this).attr('href'),
            data: {action: 'schowek_remove', id: $(this).attr('data-offer-id')},
            type: 'post',
            success: function(result) {
                if(result==1 && type=='remove') container.remove();           
                //result powinien być równy 1
            }
        });
        return false;
    });
    
    $('#offer_preview #par_adt, #offer_preview #par_chd, #offer_preview .par_chdAge').on('change', function() {
        var par_chdAge = '';
        $.each($('#offer_preview .par_chdAge'), function(i) {
            if(i>0) par_chdAge += ',';
            var wiek = $(this).val().split('.');
            par_chdAge += wiek[2]+wiek[1]+wiek[0]; 
        });
        
        $.ajax({
            url: $('#offer_preview').attr('action'),
            data: {action: 'change_offer', form: $('#offer_preview').serialize()},
            type: 'post',
            success: function(result) {
                var url = window.location.toString().split('?');
                window.location = url[0]+'?oferta='+result+'&par_adt='+$('#offer_preview #par_adt').val()+'&par_chd='+$('#offer_preview #par_chd').val()+'&par_chdAge='+par_chdAge;
            }
        });
        
     //   window.location = 'http://cititravel.pl/wakacje/?id='+$('#offer_preview #ofr_id').val()+'&par_adt='+$('#offer_preview #par_adt').val()+'&par_chd='+$('#offer_preview #par_chd').val()+'&par_chdAge='+par_chdAge;               
    });
    
    $('#offer_preview #room, #offer_preview #dep, #offer_preview #service').on('change', function() {
        var new_id = $(this).val();
        var par_chdAge = '';
        $.each($('#offer_preview .par_chdAge'), function(i) {
            if(i>0) par_chdAge += ',';
            var wiek = $(this).val().split('.');
            par_chdAge += wiek[2]+wiek[1]+wiek[0]; 
        });
        var url = window.location.toString().split('?');
       window.location = url[0]+'?oferta='+new_id+'&par_adt='+$('#offer_preview #par_adt').val()+'&par_chd='+$('#offer_preview #par_chd').val()+'&par_chdAge='+par_chdAge;                 
    });
    
    $('.wiek-dziecka').datepicker({ dateFormat: 'dd.mm.yy', changeMonth: true, changeYear: true, yearRange: "-18:+0" });	
    
      $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: parseInt($('#slider-min').val()),
      max: parseInt($('#slider-max').val()),
      values: [ parseInt($('#values-min').val()), parseInt($('#values-max').val())],
      step: 100,
      slide: function( event, ui ) {
        $( "#amount" ).val( ui.values[ 0 ] + " zł - " + ui.values[ 1 ]  + " zł");
        $('#minPrice').val(ui.values[0]);
        $('#maxPrice').val(ui.values[1]);
      }
    });
    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
      " zł - " + $( "#slider-range" ).slider( "values", 1 ) + " zł");
      
      
       $( "#slider-stars" ).slider({
      range: true,
      min: 10,
      max: 50,
      values: [ parseInt($('#stars-values-min').val()), parseInt($('#stars-values-max').val())],
      step: 10,
      create: function( event, ui) {
          if(parseInt($('#stars-values-min').val())==10) {
              $('.star11').removeClass('icon-star-normal').addClass('icon-star');
              $('.star12').removeClass('icon-star').addClass('icon-star-normal');
              $('.star13').removeClass('icon-star').addClass('icon-star-normal');
              $('.star14').removeClass('icon-star').addClass('icon-star-normal');
              $('.star15').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(parseInt($('#stars-values-min').val())==20) {
              $('.star11').removeClass('icon-star-normal').addClass('icon-star');
              $('.star12').removeClass('icon-star-normal').addClass('icon-star');
              $('.star13').removeClass('icon-star').addClass('icon-star-normal');
              $('.star14').removeClass('icon-star').addClass('icon-star-normal');
              $('.star15').removeClass('icon-star').addClass('icon-star-normal');
              
          }
          if(parseInt($('#stars-values-min').val())==30) {
              $('.star11').removeClass('icon-star-normal').addClass('icon-star');
              $('.star12').removeClass('icon-star-normal').addClass('icon-star');
              $('.star13').removeClass('icon-star-normal').addClass('icon-star');
              $('.star14').removeClass('icon-star').addClass('icon-star-normal');
              $('.star15').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(parseInt($('#stars-values-min').val())==40) {
              $('.star11').removeClass('icon-star-normal').addClass('icon-star');
              $('.star12').removeClass('icon-star-normal').addClass('icon-star');
              $('.star13').removeClass('icon-star-normal').addClass('icon-star');
              $('.star14').removeClass('icon-star-normal').addClass('icon-star');
              $('.star15').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(parseInt($('#stars-values-min').val())==50) {
              $('.star11').removeClass('icon-star-normal').addClass('icon-star');
              $('.star12').removeClass('icon-star-normal').addClass('icon-star');
              $('.star13').removeClass('icon-star-normal').addClass('icon-star');
              $('.star14').removeClass('icon-star-normal').addClass('icon-star');
              $('.star15').removeClass('icon-star-normal').addClass('icon-star');
          }
          if(parseInt($('#stars-values-max').val())==10) {
              $('.star21').removeClass('icon-star-normal').addClass('icon-star');
              $('.star22').removeClass('icon-star').addClass('icon-star-normal');
              $('.star23').removeClass('icon-star').addClass('icon-star-normal');
              $('.star24').removeClass('icon-star').addClass('icon-star-normal');
              $('.star25').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(parseInt($('#stars-values-max').val())==20) {
              $('.star21').removeClass('icon-star-normal').addClass('icon-star');
              $('.star22').removeClass('icon-star-normal').addClass('icon-star');
              $('.star23').removeClass('icon-star').addClass('icon-star-normal');
              $('.star24').removeClass('icon-star').addClass('icon-star-normal');
              $('.star25').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(parseInt($('#stars-values-max').val())==30) {
              $('.star21').removeClass('icon-star-normal').addClass('icon-star');
              $('.star22').removeClass('icon-star-normal').addClass('icon-star');
              $('.star23').removeClass('icon-star-normal').addClass('icon-star');
              $('.star24').removeClass('icon-star').addClass('icon-star-normal');
              $('.star25').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(parseInt($('#stars-values-max').val())==40) {
              $('.star21').removeClass('icon-star-normal').addClass('icon-star');
              $('.star22').removeClass('icon-star-normal').addClass('icon-star');
              $('.star23').removeClass('icon-star-normal').addClass('icon-star');
              $('.star24').removeClass('icon-star-normal').addClass('icon-star');
              $('.star25').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(parseInt($('#stars-values-max').val())==50) {
              $('.star21').removeClass('icon-star-normal').addClass('icon-star');
              $('.star22').removeClass('icon-star-normal').addClass('icon-star');
              $('.star23').removeClass('icon-star-normal').addClass('icon-star');
              $('.star24').removeClass('icon-star-normal').addClass('icon-star');
              $('.star25').removeClass('icon-star-normal').addClass('icon-star');
          }

           if(ui.values!=undefined){
            
         $('#obj_category').val(ui.values[0]+':'+ui.values[1]);}
      },
      slide: function( event, ui ) {
          if(ui.values[0]==10) {
              $('.star11').removeClass('icon-star-normal').addClass('icon-star');
              $('.star12').removeClass('icon-star').addClass('icon-star-normal');
              $('.star13').removeClass('icon-star').addClass('icon-star-normal');
              $('.star14').removeClass('icon-star').addClass('icon-star-normal');
              $('.star15').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(ui.values[0]==20) {
              $('.star12').removeClass('icon-star-normal').addClass('icon-star');
              $('.star13').removeClass('icon-star').addClass('icon-star-normal');
              $('.star14').removeClass('icon-star').addClass('icon-star-normal');
              $('.star15').removeClass('icon-star').addClass('icon-star-normal');
              
          }
          if(ui.values[0]==30) {
              $('.star13').removeClass('icon-star-normal').addClass('icon-star');
              $('.star14').removeClass('icon-star').addClass('icon-star-normal');
              $('.star15').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(ui.values[0]==40) {
              $('.star14').removeClass('icon-star-normal').addClass('icon-star');
              $('.star15').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(ui.values[0]==50) {
              $('.star15').removeClass('icon-star-normal').addClass('icon-star');
          }
          if(ui.values[1]==10) {
              $('.star21').removeClass('icon-star-normal').addClass('icon-star');
              $('.star22').removeClass('icon-star').addClass('icon-star-normal');
              $('.star23').removeClass('icon-star').addClass('icon-star-normal');
              $('.star24').removeClass('icon-star').addClass('icon-star-normal');
              $('.star25').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(ui.values[1]==20) {
              $('.star22').removeClass('icon-star-normal').addClass('icon-star');
              $('.star23').removeClass('icon-star').addClass('icon-star-normal');
              $('.star24').removeClass('icon-star').addClass('icon-star-normal');
              $('.star25').removeClass('icon-star').addClass('icon-star-normal');
              
          }
          if(ui.values[1]==30) {
              $('.star23').removeClass('icon-star-normal').addClass('icon-star');
              $('.star24').removeClass('icon-star').addClass('icon-star-normal');
              $('.star25').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(ui.values[1]==40) {
              $('.star24').removeClass('icon-star-normal').addClass('icon-star');
              $('.star25').removeClass('icon-star').addClass('icon-star-normal');
          }
          if(ui.values[1]==50) {
              $('.star25').removeClass('icon-star-normal').addClass('icon-star');
          }
          
          $('#obj_category').val(ui.values[0]+':'+ui.values[1]);
      }
  });
  
      });
      
      
      $(document).on('click', '#similarOffersSubmit', function() {
          $.ajax({
            url: $(this).attr('data-url'),
            data: {action: 'search_dates', data: $(this).attr('data-conditions'), par_adt: $(this).attr('data-par-adt'), 
                par_chd: $(this).attr('data-par-chd'), services_names: $(this).attr('data-services-names'),
                trp_depDateFrom: $('#data_wyjazdu').val(), trp_depDateTo: $('#data_powrotu').val(), trp_depCode: $('#wylot').val()},
                type: 'post',
                success: function(result) {
                    $('.search-form .results').empty().append(result);
                }
        });
        return false;
      });
      
      $("#all_inclusive1").on("ifChanged", function() {
          if($(this).is(':checked')) {
            $('#all_inclusive2').iCheck('check');
            $('#obj_xServiceId').val(1);
          }
          else {
              $('#all_inclusive2').iCheck('uncheck');
              $('#obj_xServiceId').val('');
          }
      });
      
      
       $("#all_inclusive2").on("ifChanged", function() {
          if($(this).is(':checked')) {
            $('#all_inclusive1').iCheck('check'); 
          }
          else {
              $('#all_inclusive1').iCheck('uncheck'); 
          }
      });
      
      $('select#xAttributes').selectize({
          onChange: function(value) {
               $('#obj_xAttributes').val(value);
          }
      });
      
      $('select#tourOp').selectize({
          onChange: function(value) {
               $('#ofr_tourOp').val(value);
          }
      });
      
      $('select#trpType').selectize({
          onChange: function(value) {
               $('#ofr_type').val(value);
          }
      });
      
      $('select#xServiceId').selectize({
          onChange: function(value) {
               $('#obj_xServiceId').val(value);
          }
      });
      
      $('select').selectize();
      
      $('#search_form').on('submit', function() {
         var is_hidden = $(this).find('.row--advanced-search').is(':hidden'); 
         if(is_hidden) {
             $('#advanced').val(0);
         }         
         else {
             $('#advanced').val(1);
         }
      });
      
      //funkcjonalność popupa
      
       $('.country, .region, .city').on('ifUnchecked', function() {
            $('.del-item[data-id="'+$(this).val()+'"]').parent().remove();
            if($(this).hasClass('country')) {
                name = $(this).attr('data-country-name');
            }
            else if($(this).hasClass('region')) {
                name = $(this).attr('data-region-name');
            }
            else if($(this).hasClass('city')) {
                name = $(this).attr('data-city-name');
            }
            $('.del-item[data-name="'+name+'"]').parent().remove();
            var all_checked = $('#all_checked').val().split(',');
            all_checked = all_checked.filter(function(e) { return e !== name })
            $('#all_checked').val(all_checked.join(','));
            if($('.actual-choice-list').html()=='') $('.actual-choice-list').hide();
      });

    $('.country').on('ifChanged', function() {
        var checked_tab = [];
        $.each($('.country'), function() {
            if($(this).is(':checked')) {
                checked_tab.push($(this).val())
            }    
        });
        
        var regions_checked = [];
        $.each($('.region'), function() {
            if($(this).is(':checked')) {
                regions_checked.push($(this).val())
            }    
        });
        
        var all_checked = ($('#all_checked').val()!='') ? $('#all_checked').val().split(',') : [];
        for(var i in checked_tab) {
            var country_name = $('input.country[value="'+checked_tab[i]+'"]').attr('data-country-name');
            if(jQuery.inArray(country_name, all_checked)===-1) {
                all_checked.push(country_name);
                $('.actual-choice-list').append('<li><span class="del-item" data-type="country" data-name="'+country_name+'" data-id="'+checked_tab[i]+'">'+country_name+' <span class="icon-delete del-icon"></span></span></li>').show();               
            }
            if(all_checked.length>8) $('.actual-choice-list').append('<li class="kropki"><span class="del-item"><b>...</b></span></li>');
                    
        }
        $('#all_checked').val(all_checked.join(','));
        
        if($('.span-button--del').hasClass('active') && checked_tab.length === 0){
            $('.regions-list').empty();
            $('.span-button--del').removeClass('active');
            $('.actual-choice-list').empty();
            if($('.actual-choice-list').html()=='') $('.actual-choice-list').hide();
            return false;
        }
        else if($('.span-button--add').hasClass('active') && checked_tab.length === $('.country').length) {
            get_cities(checked_tab, regions_checked);
            return false;
        }
        else if(!$('.span-button--del').hasClass('active') && !$('.span-button--add').hasClass('active')
                && checked_tab.length !== $('.country').length) {
            get_cities(checked_tab, regions_checked);
            return false;
        }
    });
    
    $('.wyspy').on('ifChanged', function() {
        $('input.country[value="15:"]').iCheck('check');
        $('input.city[value="477"]').iCheck('check');
        $('input.city[value="480"]').iCheck('check');
        $('input.city[value="488"]').iCheck('check');
        $('input.city[value="483"]').iCheck('check');
        $('input.city[value="479"]').iCheck('check');
        $('input.city[value="109"]').iCheck('check');
    });
    
    function get_cities(checked_tab, regions_checked) {
        $.ajax({
            url: $('.regions-list').attr('data-href'),
            data: {action: 'get_cities', list: checked_tab.join(','), regions_checked: regions_checked.join(','), cities_checked: jQuery('#cities').val(), trip_id: $('.regions-list').attr('data-trip-id')},
            type: 'post',
            success: function(result) {
                $('.regions-list').empty().append(result);
            }
        });
        $('.span-button--add').removeClass('active');
        $('.span-button--del').removeClass('active');    
        return false;
    }
    
    function get_country(data_type, data_id) {
        var country = '';
        $.ajax({
            url: $('.regions-list').attr('data-href'),
            data: {action: 'get_country', data_type: data_type, data_id: data_id},
            type: 'post',
            async: false,
            success: function(result) {
                country = result;
            }
        });
        return country;
    }
    
    function get_region(data_id) {
        var region = '';
        $.ajax({
            url: $('.regions-list').attr('data-href'),
            data: {action: 'get_region', data_id: data_id},
            type: 'post',
            async: false,
            success: function(result) {
                region = result;
            }
        });
        return region;
    }
    
    $(document).on('click', 'li.kropki', function() {
        if(parseInt($('.actual-choice-list').height())==30)
            $('.actual-choice-list').height('auto');
        else
            $('.actual-choice-list').height('30px');
        return false;
    });
    
    $(document).on('ifChanged', '.region', function() {
        var regions_checked = ($('#regions').val()!='') ? $('#regions').val().split(',') : [];
        var checked_tab = [];
        $.each($('.region'), function() {
            if($(this).is(':checked')) {
                checked_tab.push($(this).attr('data-region-id'));
                regions_checked.push($(this).attr('data-region-id'));
            } 
        });   
        
        $('#regions').val(regions_checked.join(','));
        
        var all_checked = ($('#all_checked').val()!='') ? $('#all_checked').val().split(',') : [];
        for(var i in checked_tab) {
            var country_name = $('input.region[value="'+checked_tab[i]+'"]').attr('data-region-name');
            var cont_width = $('.trip-direction-container-top').innerWidth();   
            if(jQuery.inArray(country_name, all_checked)===-1) {
                all_checked.push(country_name);
                $('.actual-choice-list').append('<li><span class="del-item" data-type="region" data-name="'+country_name+'" data-id="'+checked_tab[i]+'">'+country_name+' <span class="icon-delete del-icon"></span></span></li>').show();               
            }
            if(all_checked.length>8) $('.actual-choice-list').append('<li class="kropki"><span class="del-item"><b>...</b></span></li>');
                    
        }
        $('#all_checked').val(all_checked.join(','));
    });
    
    $(document).on('ifChanged', '.city', function() {
        var checked_tab = [];
        $.each($('.city'), function() {
            if($(this).is(':checked')) {
                checked_tab.push($(this).attr('data-city-id'));
            } 
        });    
        
        var all_checked = ($('#all_checked').val()!='') ? $('#all_checked').val().split(',') : [];
        for(var i in checked_tab) {
            var country_name = $('input.city[value="'+checked_tab[i]+'"]').attr('data-city-name');
            var cont_width = $('.trip-direction-container-top').innerWidth();   
            if(jQuery.inArray(country_name, all_checked)===-1) {
                all_checked.push(country_name);
                $('.actual-choice-list').append('<li><span class="del-item" data-type="city" data-name="'+country_name+'" data-id="'+checked_tab[i]+'">'+country_name+' <span class="icon-delete del-icon"></span></span></li>').show();               
            }
            if(all_checked.length>8) $('.actual-choice-list').append('<li class="kropki"><span class="del-item"><b>...</b></span></li>');
                    
        }
        $('#all_checked').val(all_checked.join(','));
    });
    
    $('.btn--choose').on('click', function() {
        var countries_tab = [];
        var cities_tab = [];
        var hotels_tab = [];
        
        var checked_tab = ($('#all_checked').val()!='') ? $('#all_checked').val().split(',') : [];
        
        $.each($('.actual-choice-list li span.del-item'), function() {
            if($(this).attr('data-type')=='country') {
                countries_tab.push($(this).attr('data-id'));
            }
            else if($(this).attr('data-type')=='region') {
                countries_tab.push($(this).attr('data-id'));
            }
            else if($(this).attr('data-type')=='city') {
                cities_tab.push($(this).attr('data-name'));
            }
            else {
                hotels_tab.push($(this).attr('data-name'));
            }
        });    
        
        $('#trp_destination').val(countries_tab.join(','));
        $('#cities').val(cities_tab.join(','));
        $('#hotels').val(hotels_tab.join(','));
        var list_string = checked_tab.join(', ');
        var list = (list_string.length > 18) ? list_string.substr(0,18)+'...' : list_string;
        $('.trip-direction').val(list);
    });
    
    $('.trips-input').on('keyup', function() {
        var input = $(this);
        $.ajax({
            url: $('.trips-input').attr('data-href'),
            data: {action: 'search_in_all', val: input.val(), trip_id: $('.trips-input').attr('data-trip-id')},
            type: 'post',
            success: function(result) {
                $('.destinations-search').empty().append(result);
                $('.destinations-search').addClass('active');
                $('.destinations-search').addClass('loading');
                $.ajax({
                    url: $('.trips-input').attr('data-href'),
                    data: {action: 'search_hotel', val: input.val()},
                    type: 'post',
                    success: function(result) {  
                        $('.destinations-search .ul-hotels').empty().append(result);
                        $('.destinations-search').removeClass('loading');
                    }
                });
            }
        }); 
    });
    
    $(document).on('click', 'li.search_item', function() {
        var checked_tab = $('#all_checked').val().split(',');
        if(jQuery.inArray($(this).attr('data-name'), checked_tab)===-1) {
            checked_tab.push($(this).attr('data-name'));
            var data_id = $('.actual-choice-list').find('span.del-item[data-name=\"'+$(this).attr('data-name')+'\"]').attr('data-id');
            if(data_id==undefined && $(this).attr('data-type')!='country' && $(this).attr('data-type')!='region' && $(this).attr('data-type')!='city')
                $('.actual-choice-list').append('<li><span class="del-item" data-type="'+$(this).attr('data-type')+'" data-name="'+$(this).attr('data-name')+'" data-id="'+$(this).attr('data-id')+'">'+$(this).attr('data-name')+' <span class="icon-delete del-icon"></span></span></li>').show();                     
            if($(this).attr('data-type')=='region' || $(this).attr('data-type')=='city') {
                var country_parent_id = get_country($(this).attr('data-type'), $(this).attr('data-id'));
                $('input.country[value="'+country_parent_id+'"]').iCheck('check'); 
            }
            if($(this).attr('data-type')=='city') {
                var region_name = get_region($(this).attr('data-id'));
                checked_tab.push(region_name);
            }
            $('input.country[value="'+$(this).attr('data-id')+'"]').iCheck('check'); 
            $('input.region[value="'+$(this).attr('data-id')+'"]').iCheck('check'); 
            $('input.city[value="'+$(this).attr('data-id')+'"]').iCheck('check'); 
            $('#all_checked').val(checked_tab.join(','));
        }
        $('.destinations-search').removeClass('active');
        $('.trips-input').val('');
    });
    
    $(document).on('click', '.icon-delete', function() {
        var data_id = $(this).parent().attr('data-id');
        var data_name = $(this).parent().attr('data-name');
        $('input.country[value="'+data_id+'"]').iCheck('uncheck'); 
        $('input.country[data-country-name="'+data_name+'"]').iCheck('uncheck'); 
        $('input.region[value="'+data_id+'"]').iCheck('uncheck'); 
        $('input.region[data-region-name="'+data_name+'"]').iCheck('uncheck'); 
        $('input.city[value="'+data_id+'"]').iCheck('uncheck'); 
        $('input.city[data-city-name="'+data_name+'"]').iCheck('uncheck'); 
        if(!$(this).parents('.trip-direction-container-top').length && $(this).parent().hasClass('input-hld') == false) {
          $(this).parent().parent().remove();
        }
        if($('.actual-choice-list').html()=='') $('.actual-choice-list').hide();
    })
    
    jQuery(document).ready(function() {
            var checked_tab_country = [];
            $.each($('.country'), function() {
                if($(this).is(':checked')) {
                    checked_tab_country.push($(this).val());
                } 
            });    
            
            if($('#regions').length){
              var regions_checked = jQuery('#regions').val().split(',');            
              get_cities(checked_tab_country, regions_checked);    
            }
            
             $('.actual-choice-list').empty();

            if($('#all_checked').length){
              var all_checked = ($('#all_checked').val()!='') ? $('#all_checked').val().split(',') : [];
            }
            
            var checked_tab_country = checked_tab_country.filter((v, i, a) => a.indexOf(v) === i); 
            for(var i in checked_tab_country) {
                var country_name = $('input.country[value="'+checked_tab_country[i]+'"]').attr('data-country-name');
                var data_id = $('.actual-choice-list').find('span.del-item[data-name=\"'+checked_tab_country[i]+'\"]').attr('data-id');
                if(country_name!='' && data_id==undefined)
                    $('.actual-choice-list').append('<li><span class="del-item" data-type="country" data-name="'+country_name+'" data-id="'+checked_tab_country[i]+'">'+country_name+' <span class="icon-delete del-icon"></span></span></li>').show();               
                if(all_checked.length>8) $('.actual-choice-list').append('<li class="kropki"><span class="del-item"><b>...</b></span></li>');
            }
   
        });
