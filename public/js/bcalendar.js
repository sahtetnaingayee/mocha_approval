var AppCalendar = function(url) {


    return {
        //main function to initiate the module
        init: function(url) {
            this.initCalendar(url);
        },

        initCalendar: function(url) {

            if (!jQuery().fullCalendar) {
                return;
            }



            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var h = {};

            if (1!=1) {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        right: 'title, prev, next',
                        center: '',
                        left: 'month, today'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        right: 'title',
                        center: '',
                        left: 'month,today'
                    };
                }
            } else {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        left: 'title, prev, next',
                        center: '',
                        right: 'today,month'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month'
                    };
                }
            }

            var initDrag = function(el) {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim(el.text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                el.data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                el.draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            };

            var addEvent = function(title) {
                title = title.length === 0 ? "Untitled Event" : title;
                var html = $('<div class="external-event label label-default">' + title + '</div>');
                jQuery('#event_box').append(html);
                initDrag(html);
            };

            $('#external-events div.external-event').each(function() {
                initDrag($(this));
            });

            $('#event_add').unbind('click').click(function() {
                var title = $('#event_title').val();
                addEvent(title);
            });

            //predefined events
            $('#event_box').html("");
            addEvent("My Event 1");
            addEvent("My Event 2");
            addEvent("My Event 3");
            addEvent("My Event 4");
            addEvent("My Event 5");
            addEvent("My Event 6");



            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            $('#calendar').fullCalendar({ //re-initialize the calendar
                header: h,
                defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/ 
                slotMinutes: 15,

                selectable: true,
                selectConstraint: {
                    start: $.fullCalendar.moment().subtract(1, 'days'),
                    end: $.fullCalendar.moment().startOf('month').add(1, 'month')
                },
                dayNamesShort: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],

                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');
                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.className = $(this).attr("data-class");

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },


                events:{

                    url:url,
                },

                eventRender: function(event, element) {

                    console.log(event);

                    if(event.icon){  


                        var $status='';

                        var url='http://localhost:8888/moca/public/';
                       // var url='http://174.138.31.228/';
                        var link_url=url+'/admin_page/post/'+event.page_id+'/'+event.id;

                        var html="<a href='"+link_url+"'><img src='"+url+event.image_path+"' class='img_thumbnail'>"+event.title+"</a>";

                        element.find(".fc-title").html(html);

                        if(event.status==10){//Review

                            $status='progress';

                        }else if(event.status==20){

                            $status='approved';

                        }else{

                            $status='normal';
                        }

                        element.addClass($status);


                        // element.find(".fc-title").prepend(html);
                        
                    }

                    

                } ,

                dayRender:function (date, cell) {

                    // The cell has a data-date tag with the date we can use vs date.format('YYYY-MM-DD')
                    var theDate = $(cell).data('date');
                    // Find the day number td for the date
                    var fcDaySkel = $("#calendar div.fc-content-skeleton td[data-date='"+theDate+"'].fc-day-number");
                    fcDaySkel.prepend("<img src='' id='editar_control_"+theDate+"_id'/>");
                },


                dayClick: function(date, jsEvent, view) {

                    var page_id=$("input[name='page_id']").val();
                    /* Go to the new URL */
                    window.location.href='http://localhost:8888/moca/public/admin_post/'+page_id+'/'+date.format();
                    //window.location.href='http://174.138.31.228/admin_post/'+page_id+'/'+date.format();
                }       

            });

        }

    };

}();

