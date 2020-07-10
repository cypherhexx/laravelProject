(function($) {


    var highlighter = function highlighter(item) {

        return (settings.displayText) ? item[settings.displayText] : item;
    };

    settings = {
        minLength: 3,
        source: [],
        highlighter: highlighter,
        displayText: null,
        anchorLink: null,
        fitToElement: false,
        noRecordFoundMessage: "No record found"
    };
    dataList: [];

    style = {
        listHolderClass: 'micoSearch'
    };

    $.fn.micoSearch = function(options) {



        settings = $.extend({}, settings, options);

        $(this).keyup(function(event) {

            if (!this.value) {
                return;
            }
            this.value = this.value.trim();
            if (this.value.length < settings.minLength) {

                return;
            }
            $(this).parent().find('ul.' + style.listHolderClass).remove();
            $(document).on('click', function(event) {

                remove_element(this);
            });


            run(this);




        });


        return this;
    };

    function run($scope) {
        if ($scope.value.length > 0) {

            $.when(set_source($scope.value)).then(function() {

                    $html = genHtml(get_source());

                    $($html).insertAfter($scope);
                }

            );
        }


    }

    function remove_element($scope) {
        $($scope).find('ul.' + style.listHolderClass).remove();
    }

    function get_source() {

        return dataList;
    }

    function set_source($query) {
        var dfd = jQuery.Deferred();

        if ($.isFunction(settings.source)) {
            settings.source($query).done(function(data) {
                if (data) {
                    dataList = data;
                }
                dfd.resolve("hurray");
            });

        } else {
            dataList = settings.source;
            dfd.resolve("hurray");
        }

        return dfd.promise();
    }



    function genHtml(data) {
        var fitToElement = (settings.fitToElement) ? 'width:100%;' : '';
        var str = '<ul class="' + style.listHolderClass + ' dropdown-menu" role="listbox" style="top: 31px; left: 0px; display: block; height: auto; max-height: 350px; overflow-x: hidden; ' + fitToElement + '">';

        if (data.length > 0) {

            $.each(data, function(key, item) {
                var label = settings.highlighter(item);
                var anchorLink = (settings.anchorLink) ? item[settings.anchorLink] : "#";
                str += '<li class="active"><a class="dropdown-item" href="' + anchorLink + '" role="option">' + label + '</a></li>';
            });

        } else {
            str += '<li class="active"><a class="dropdown-item" href="#" role="option">' + settings.noRecordFoundMessage + '</a></li>';
        }

        str += '</ul>';
        return str;
    }




})(jQuery);


$(function() {
    $('#global_search').micoSearch({

        displayText: 'label',
        anchorLink : 'link',
        fitToElement : true,
        noRecordFoundMessage : global_config.lang_no_record_found,
        source: function (query) {
             return $.get( global_config.url_global_search , { query: query }, function (data) {                    
                       return data;                    
            });
        },
        
        highlighter: function(item) {     
                        
              var str   = '<div>' + item.label + '</div>';
              str       = str + '<small id="emailHelp" class="form-text text-muted">' + item.type  + '</small>'
              return (str);
        }                
                     
    });

});
var notificationListVueInstance = new Vue({

    el: '#notificationList',
    data: {
        notifications :[],
        loadingEnabled : false
    },

  computed: {},
  methods: {        

        showNotifications: function(){
           $scope = this;
           $("#notification_badge").html("").hide();
           $scope.loadingEnabled = true;
           $.post( global_config.url_get_unread_notifications , { "_token":  global_config.csrf_token })
            .done(function( data ) {
                $scope.notifications = data;
                
            })
            .always(function() {
                $scope.loadingEnabled = false;
            });
        }
    }
    

 });
// ----------------- Attachment Functionality ----------------


/* this expects global_config variable (in the main.blade.php file) to have the following values:
    # url_upload_attachment
    # url_delete_temporary_attachment
*/

    $(document).on('click', '.upload_link', function(e){
            e.preventDefault();
            $('#attachment').trigger('click');
    });

    $(document).on('change', '#attachment', function(e){

            var formId              = $(this).data('form-id');
            formId                  = (formId) ? formId : 'form';
            var shortCodeInputId    = $(this).data('short-code-input-id');


            var fileInput           = document.querySelector('#attachment');

            var xhr = new XMLHttpRequest();
            xhr.open('POST', global_config.url_upload_attachment );
           
            xhr.setRequestHeader("X-CSRF-Token", global_config.csrf_token);


            xhr.upload.onprogress = function(e) 
            {
            //    $('#file_loaded').val(e.loaded);
            //    $('#file_total').val(e.total);
                //console.log("Loaded " + e.loaded + " : Total : " + e.total);
                /* 
                * values that indicate the progression
                * e.loaded
                * e.total
                */
                $("#uploading_on_progress").show();
            };

            xhr.onload = function()
            {
                
                $("#uploading_on_progress").hide();
                

                var data;
                if (xhr.status != 200) 
                {
                    alert('Could not upload the attachment');
                    return;
                }
                if (!xhr.responseText) 
                {
                    alert('Could not upload the attachment');
                    return;
                }
                
                data = JSON.parse(xhr.responseText);

                $key = Math.floor(Math.random() *  1000); 

                $html = '<li class="list-group-item">';

                if(shortCodeInputId)
                {
                    $html += ' <a href="#" data-insert-in="' + shortCodeInputId +'" data-short-code="' + data.short_code +'" class="insert_short_code"> ' + data.display_name +' </a>';
                }
                else
                {
                     $html += data.display_name ;
                }


                $html += ' <a href="' + data.name +'" data-key="' + $key +'" class="btn btn-danger btn-sm remove_tmp_attachment"> <i class="far fa-trash-alt"></i> </a>';

                

                $html += '</li>';

                $('#list_of_attachments').append($html);
                $('<input>').attr({
                    type: 'hidden',
                    class: 'attachment',
                    name: 'attachment[' + $key +']',
                    value: data.encrypted_value_for_input
                }).appendTo(formId);
                

                // Append Short Code to Text Area
                
                if(shortCodeInputId)
                {
                   
                    var box = $(shortCodeInputId);
                    box.val(box.val() + " " + data.short_code );
                }

                $( document ).trigger("upload_complete");
                
                
            };

            // upload success
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
            {
                // if your server sends a message on upload sucess, 
                // get it with xhr.responseText
               console.log(xhr.responseText);
            }

            var form = new FormData();
            //form.append('title', this.files[0].name);
            form.append('file', fileInput.files[0]);

            xhr.send(form);
        });

            
        

        $(document).on('click', '.remove_tmp_attachment', function(e){
            e.preventDefault();
            var element = $(this);
            
            var key = element.data('key');
            $("input[name='attachment[" + $key +"]']").remove();        
            element.parent().remove();

         

            $.post( global_config.url_delete_temporary_attachment , { 
                "_token": global_config.csrf_token ,
                filename: element.attr('href') 
            } );

            $( document ).trigger("tmp_attachment_removed");
        });
var updateQueryStringParam = function (key, value) {

        var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
            urlQueryString = document.location.search,
            newParam = key + '=' + value,
            params = '?' + newParam;

        // If the "search" string exists, then build params from it
        if (urlQueryString) {

            updateRegex = new RegExp('([\?&])' + key + '[^&]*');
            removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

            if( typeof value == 'undefined' || value == null || value == '' ) { // Remove param if value is empty

                params = urlQueryString.replace(removeRegex, "$1");
                params = params.replace( /[&;]$/, "" );

            } else if (urlQueryString.match(updateRegex) !== null) { // If param exists already, update it

                params = urlQueryString.replace(updateRegex, "$1" + newParam);

            } else { // Otherwise, add it to end of query string

                params = urlQueryString + '&' + newParam;

            }

        }
        window.history.replaceState({}, "", baseUrl + params);
    };

    function get_url_parameters()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }


$(function(){


$('[data-toggle="tooltip"]').tooltip();


        $('#sidebarCollapse').on('click', function (e) {
            e.preventDefault();
            $('#sidebar').toggleClass('active');


        });

        $( ".selectPickerWithoutSearch" ).select2( {
            theme: "bootstrap",

            minimumResultsForSearch: -1,
            placeholder: function(){
                $(this).data('placeholder');
            },
            maximumSelectionSize: 6
        } );

        $( ".selectpicker" ).select2( {
            theme: "bootstrap",
            placeholder: function(){
                $(this).data('placeholder');
            },
            maximumSelectionSize: 6
        } );

        $( ".select2-multiple" ).select2( {
            theme: "bootstrap",
            placeholder: "Nothing Selected",
            maximumSelectionSize: 6
        } );

        $('.four-boot').fourBoot();





        ranges = {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last 12 Months': [moment().subtract(11, 'month').startOf('month'), moment()]
        };

        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('#reportrange span').html(start.format('D , MMMM , YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges : ranges,
            locale: {

              // format: 'DD/MM/YYYY'
              format : 'MMM D, YYYY'
            }
        }, cb);

        cb(start, end);  


        $('.initially_empty_datepicker').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }

            }).on('apply.daterangepicker', function(ev, picker) {
                
                $(this).val(picker.endDate.format('DD-MM-YYYY'));
            });


        $('.datepickerAndTime').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY hh:mm A'
            },
            startDate: moment()

        });    



        $('.datepicker').daterangepicker({

            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
            startDate: moment()

        });



        // Bootstrap NavBar Multi Level
        $('.dropdown-submenu > a').on("click", function(e) {
            e.preventDefault();
            var submenu = $(this);
            $('.dropdown-submenu .dropdown-menu').removeClass('show');
            submenu.next('.dropdown-menu').addClass('show');
            e.stopPropagation();
        });

        $('.dropdown').on("hidden.bs.dropdown", function() {
            // hide any open menus when parent closes
            $('.dropdown-menu.show').removeClass('show');
        });

        // End of Bootstrap NavBar Multi Level



});



    $(document).on('click','.delete_item',function(e){
        //  $(this) = your current element that clicked.
        // additional code
        e.preventDefault();
        var url = $(this).attr('href');   

        swal({
              title: global_config.txt_delete_confirm_title ,
              text:  global_config.txt_delete_confirm_text ,
              icon: "warning",
              buttons: {
                        cancel: {
                          text: global_config.txt_btn_cancel ,
                          value: null,
                          visible: true,
                          className: "",
                          closeModal: true,
                        },
                        confirm: {
                          text: global_config.txt_yes ,
                          value: true,
                          visible: true,
                          className: "",
                          closeModal: true
                        }
                      },
              dangerMode: true,
              
            }).then(function (willDelete) {
              if (willDelete) {
                window.location.href = url;
              } 
            });

    });


    $(document).on('click', '.insert_short_code', function(e){
            e.preventDefault();
            var element = $(this);
            
            var short_code = element.data('short-code');
            var insert_in = element.data('insert-in');

            var box = $(insert_in);
            box.val(box.val() + " " +short_code );
           
    });



/* Notes */

$(function () {
        

    function toggleNote(id)
    {
        console.log("toggleNote : " + id);
        var inlineEdit      = $('.inlineEdit_' + id);
        var note_details    = $('.note_details_'+ id);

        if($(inlineEdit).is(":hidden"))
        {            
            inlineEdit.show();
            note_details.hide();
        }
        else
        {            
            inlineEdit.hide();
            note_details.show();
        }
    }

$('.editNote').click(function(e){
    e.preventDefault();

    var id = $(this).data('id');
   
    toggleNote(id);


});

$('.saveNote').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
    
    var newNote = $('.inlineEdit_' + id).find('textarea[name=details]').val();

    $('.note_details_' + id).html(newNote);

    toggleNote(id);
    saveNote(id, newNote);


});

        

});




    function saveNote(id, $newNote)
    {
        var postData = {
            _token : global_config.csrf_token,
            id : id,
            details : $newNote
        };
        $.post(global_config.url_patch_note , postData ).done(function( response ) {

            if(response.status == 1)
            {
                $.jGrowl(response.msg, { position: 'bottom-right'});
            }
            else
            {

            }
        });

    }

    function deleteNote(id)
    {
        var postData = {
            _token : global_config.csrf_token,
            id : id
            
        };
        $.post(global_config.url_delete_note , postData ).done(function( response ) {

            if(response.status == 1)
            {
                $('.note_thread_' + id).remove();
                $.jGrowl(response.msg, { position: 'bottom-right'});
            }
            else
            {

            }
        });

    }

$(document).on('click','.delete_note',function(e){

    e.preventDefault();

    id = $(this).data('id');


    swal({
      title: global_config.txt_delete_confirm_title ,
      text:  global_config.txt_delete_confirm_text ,
      icon: "warning",
      buttons: {
                cancel: {
                  text: global_config.txt_btn_cancel ,
                  value: null,
                  visible: true,
                  className: "",
                  closeModal: true,
                },
                confirm: {
                  text: global_config.txt_yes ,
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true
                }
              },
      dangerMode: true,
      
    }).then(function (willDelete) {
      if (willDelete) {
        
        deleteNote(id);
      } 
    });

});

/* End of Notes */
/* this expects global_config variable (in the main.blade.php file) to have the following values:
  pusher_log_status ,
  pusher_app_key , 
  pusher_cluster,
  pusher_channel,
  is_pusher_enable,
*/

if(global_config.is_pusher_enable)
{
    Pusher.logToConsole = global_config.pusher_log_status ;  

    var pusher = new Pusher(global_config.pusher_app_key , {
      cluster: global_config.pusher_cluster ,
      forceTLS: true
    });

    var channel = pusher.subscribe(global_config.pusher_channel);

    channel.bind('new.notification', function(data) {          
      var $number = $("#notification_badge").text();
      var num_of_notification = ($number) ? parseInt($number) : 0 ;
      $("#notification_badge").html(num_of_notification+1).show();

    });

}