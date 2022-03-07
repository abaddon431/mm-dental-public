$(document).ready(function(){
      //loader();
      // initialize dashboard


      //local functionality to fetch data from remote server
      // CHANGE THIS -- uncomment the next function to enable remote connection to a database if you have a website hosted online
      // (function(){
      //   $.post('includes/request_dump.php',function(data)
      //   {
      //     if(data!=="")
      //     {
      //       console.log(data);
      //     }
      //   })
      //   setTimeout(arguments.callee, 60000);
      // })();

      initializeTooltips();
      $('#main-div').load("pages/dashboard.php",function()
      {
        dashboardCharts();
        $("#dashboard").addClass("active");
      });
      
      var calendar,event_start;
      // onclick functions on off-canvas
      $("#dashboard").on("click",function(){
        // piece of code to add active class on current clicked nav
          $("#main-div").empty();
          $(".nav-items").removeClass("active");
          $(this).addClass("active"); 
          $('#main-div').load("pages/dashboard.php",function(){
            dashboardCharts();
          });
      });
      
      //patient table
      $("#patient-records").on("click",function(){
        $("#main-div").empty();
        $(".nav-items").removeClass("active");
        $(this).addClass("active"); 
        $('#main-div').load("pages/patients-table.php",function(){
          getInitialTable();
        });
        // patient table initialize
        
        //add patient
        $('#main-div').on('click','#add-patient-btn',function(){
          var this_id=0;
          $.get("includes/record/patient-form.php",function(data)
          {
            $('#main-div').html(data);
            $("#patient_add_id").val(this_id);
            $("#pFormTitle").html("New Patient");
            $("#pSave").val("Add");
          });
        });
        //patient add or edit
        $("#main-div").on('submit','.pForm',function(e){
          var method=$('#pSave').val();
          var patient_id=$("#patient_add_id").val();
          if(method.toLowerCase()==="save")
          {
            patientAdd(patient_id,"save");
          }
          else if(method.toLowerCase()==="add")
          {
            patientAdd(patient_id,"add");
          }
          e.preventDefault();
          e.stopImmediatePropagation();
        });
        
        /////
        $("#main-div").on('submit','#search-field',function(e){
          e.preventDefault();
        });

        $("#main-div").on('submit','#app-search-field',function(e){
          e.preventDefault();
        });
        //////
        //dynamic table search;


        
        $('#main-div').on('keyup','#search-patient-field',function(e){
          var input=$(this).val();
          limit=$(".limit-select option:selected").val();
          $.post("includes/record/patient-page-fetch.php",{input:input,limit:limit},function(data){
            $('.patient-table').html(data);
          });
          e.stopImmediatePropagation();
        });
        /////////////////////!!!!!!!!!!!!!!!!!!!1///////////////////////////
        $('#main-div').on('click','.page-link',function(e){
          limit=$(".limit-select option:selected").val();
          page=$(this).data('value');
          $.post("includes/record/patient-page-fetch.php",{page:page,limit:limit},function(data)
          {
            $('.patient-table').html(data);
          });
          e.preventDefault();
          e.stopImmediatePropagation();
        });
        
        $('#main-div').on('change','.limit-select',function(){
          limit=$(this).val();
          input=$("#search-patient-field").val();
          $.post("includes/record/patient-page-fetch.php",{input:input,limit:limit},function(data)
          {
            $('.patient-table').html(data);
          });
        });



        //load patient info after clicking on the name
        $('#main-div').on('click','.first_name', function(e){
          var this_id= $(this).attr("id");
          $("#main-div").empty();
          $('#main-div').load("includes/record/patient-fetch.php",{id:this_id},function(){
          
            getSchedule(this_id);

            $('.custom-nav-patient').on('click','#patient_dental',function(e){
              $('.patient-nav').removeClass('active');
              $(this).addClass("active"); 
              var patient_id=$('.patient-nav-id').attr('id');
              $('.patient-nav-main').load("includes/record/patient-nav-chart.php",{id:patient_id});
              e.stopImmediatePropagation();
            });

            //initialize pathology restoration
            getInitialProc(1);
            getInitialProc(2);
            getInitialProc(3);

            //show modal
            $('.patient-nav-main').on('click','.dc-teeth',function(e){
              var tooth_id=$(this).attr('id').split('-').pop();
              var tooth_class=$(this).attr('class').split(' ').pop();
              var patientID=$('.patient-nav-id').attr('id');
              $('.tooth-id').val(tooth_id);
              $('.patient-id').val(patientID);
              $('.is-group').val(0);
              if(tooth_class!=="missing"){
                $('#options_modal').modal('show');
              }
              else{
                $('#change_missing_modal').modal('show');
              }
              e.stopImmediatePropagation();
            });
            //other
            $('.patient-nav-main').on('click','.multi-toggle',function(e){
              var x=document.getElementById("group-select-one");
              var y=document.getElementById("group-select-two");
              var z=document.getElementById("group-select-done");
              if(x.style.display==="none" && y.style.display==="none")
              {
                x.style.display="table-row";
                y.style.display="table-row";
                z.style.display="table-row";
              }
              else
              {
                x.style.display="none";
                y.style.display="none";
                z.style.display="none";
              }
            });
            $('.patient-nav-main').on('click','#group-select-done',function(e){
              var teeth_array=[];
              $.each($("input[name='group-select-teeth']:checked"),function()
                {
                  teeth_array.push($(this).val());
                });
              var patientID=$('.patient-nav-id').attr('id');
              teeth_group=teeth_array.join(",");
              $('.is-group').val(1);
              $('.tooth-id').val(teeth_group);
              $('.patient-id').val(patientID);
              $('#options_modal').modal('show');
            });
            $("#options_modal").on('click','#other-click',function(){
              $('#other_form')[0].reset();
              $('#other-tooth-id-text').html("#"+$('.tooth-id').val());
              $("#options_modal").modal('hide');
              $("#other_modal_label").html("Clinic Procedures");
              $('#other_modal').modal('show');
            });

            $("#other_form").submit(function(e){
              var isgroup=$(".is-group").val();
              var tid=$(".tooth-id").val();
              var pid=$(".patient-id").val();
              var add_procedure=$('.other-procedure').val();
              var other_date=$('#other-date').val();
              var other_note=$('#other-note').val();
              var other_option=$("input[name='other-option']:checked").val();
              var operations=[
                tid,
                $('.other-procedure option:selected').text(),
              ];
              operation_desc=operations.join(", ");
              operation_code=add_procedure;
              $.post("includes/record/tooth-insert-operation.php",{isgroup:isgroup,pid:pid,tid:tid,opc:operation_code,opd:operation_desc,add:add_procedure,status:other_option,date:other_date,note:other_note},function(data){
                $("#other_modal").modal('hide');
                $('#message_modal').modal('show');
                $("#message_modal_msg").empty();
                $("#message_modal_msg").append('<p>'+ data +'</p>');
                getInitialChart(pid);
              });
              e.preventDefault();
            });
            //pathology modal functions
            $("#options_modal").on('click','#patho-click',function(){
              $('#patho-procedure-select option').prop('selected', function () {
                return this.defaultSelected;
              });
              $(".patho-category").remove();
              $(".patho-tooth-part").remove();
              $(".patho-sub").remove();
              $('#patho_form')[0].reset();
              $('#patho-tooth-id-text').html("#"+$('.tooth-id').val());
              $("#options_modal").modal('hide');
              $("#patho_modal_label").html("pathology");
              $('#patho_modal').modal('show');
            });
            $(".patho-group").on('change',".patho-procedure",function(){
              var procedure_id=$(this).val();
              var category_class="patho-category";
              $.post("includes/record/get-category.php",{id:procedure_id,category:category_class},function(data){
                  $(".patho-category").remove();
                  $(".patho-tooth-part").remove();
                  $(".patho-sub").remove();
                  $(".patho-group").append(data);
              });
            });
            $(".patho-group").on('change',".patho-category",function(){
                var category_id=$(this).val();
                var sub_class="patho-sub";
                $.post("includes/record/get-sub.php",{id:category_id,sub:sub_class},function(data){
                  $(".patho-sub").remove();
                  $(".patho-group").append(data);
                })
            });
            
            //submit
            $("#patho_modal").submit(function(e){
              var isgroup=$(".is-group").val();
              var zones=[];
              var zone_join="";
              var tid=$(".tooth-id").val();
              var pid=$(".patient-id").val();
              var add_procedure=$('.patho-procedure').val();
              var patho_date=$('#patho-date').val();
              var patho_note=$('#patho-note').val();
              var patho_option=$("input[name='patho-option']:checked").val();
              var operations=[
                tid,
                $('.patho-procedure option:selected').text(),
              ];
              var operationc=[
                add_procedure,
              ];
              if($('.patho-tooth-part').length>0)
              {
                $.each($("input[name='patho-zone']:checked"),function()
                {
                  zones.push($(this).val());
                });
                if(zones.length>0)
                {
                  zone_join=zones.join(", ");
                  operations.push(zone_join);
                }
              }
              if($('.patho-category option:selected').text()!=="")
              {
                operations.push($('.patho-category option:selected').text());
                operationc.push($('.patho-category').val());
              }
              if($('.patho-sub option:selected').text()!=="")
              {
                operations.push($('.patho-sub option:selected').text());
                operationc.push($('.patho-sub').val());
              }
              operation_desc=operations.join(", ");
              operation_code=operationc.join("-");
              $.post("includes/record/tooth-insert-operation.php",{isgroup:isgroup,pid:pid,tid:tid,opc:operation_code,opd:operation_desc,add:add_procedure,status:patho_option,date:patho_date,note:patho_note},function(data){
                $("#patho_modal").modal('hide');
                $('#message_modal').modal('show');
                $("#message_modal_msg").empty();
                $("#message_modal_msg").append('<p>'+ data +'</p>');
                getInitialChart(pid);
              });
              e.preventDefault();
              e.stopImmediatePropagation();
            });
            $(".patho-group").on('click', "#patho-zones-btn",function(e){
              $(this).next().toggle();
            });
            $(".patho-group").on('click', "#patho-zone-dropdown",function(e){
              e.stopPropagation();
            });

            //resto modal
            $("#options_modal").on('click','#resto-click',function(){
              $('#resto-procedure-select option').prop('selected', function () {
                return this.defaultSelected;
              });
              $(".resto-category").remove();
              $(".resto-tooth-part").remove();
              $(".resto-sub").remove();
              $('#resto_form')[0].reset();
              $('#resto-tooth-id-text').html("#"+$('.tooth-id').val());
              $("#options_modal").modal('hide');
              $("#resto_modal_label").html("restoration");
              $('#resto_modal').modal('show');
            });
            $(".resto-group").on('change',".resto-procedure",function(){
              var procedure_id=$(this).val();
              var category_class="resto-category";
              $.post("includes/record/get-category.php",{id:procedure_id,category:category_class},function(data){
                  $(".resto-category").remove();
                  $(".resto-tooth-part").remove();
                  $(".resto-sub").remove();
                  $(".resto-group").append(data);
              });
            });
            $(".resto-group").on('change',".resto-category",function(){
              var category_id=$(this).val();
              var sub_class="resto-sub";
              $.post("includes/record/get-sub.php",{id:category_id,sub:sub_class},function(data){
                $(".resto-sub").remove();
                $(".resto-group").append(data);
              })
            });
            //submit
            $("#resto_modal").submit(function(e){
              
              var isgroup=$(".is-group").val();
              var zones=[];
              var zone_join="";
              var tid=$(".tooth-id").val();
              var pid=$(".patient-id").val();
              var add_procedure=$('.resto-procedure').val();
              var resto_date=$('#resto-date').val();
              var resto_note=$('#resto-note').val();
              var resto_option=$("input[name='resto-option']:checked").val();
              var operations=[
                tid,
                $('.resto-procedure option:selected').text(),
              ];
              var operationc=[
                add_procedure,
              ];
              if($('.resto-tooth-part').length>0)
              {
                $.each($("input[name='resto-zone']:checked"),function()
                {
                  zones.push($(this).val());
                });
                if(zones.length>0)
                {
                  zone_join=zones.join(", ");
                  operations.push(zone_join);
                }
              }
              if($('.resto-category option:selected').text()!=="")
              {
                operations.push($('.resto-category option:selected').text());
                operationc.push($('.resto-category').val());
              }
              if($('.resto-sub option:selected').text()!=="")
              {
                operations.push($('.resto-sub option:selected').text());
                operationc.push($('.resto-sub').val());
              }
              operation_desc=operations.join(", ");
              operation_code=operationc.join("-");
              $.post("includes/record/tooth-insert-operation.php",{isgroup:isgroup,pid:pid,tid:tid,opc:operation_code,opd:operation_desc,add:add_procedure,status:resto_option,date:resto_date,note:resto_note},function(data){
                $("#resto_modal").modal('hide');
                $('#message_modal').modal('show');
                $("#message_modal_msg").empty();
                $("#message_modal_msg").append('<p>'+ data +'</p>');
                getInitialChart(pid);
              });
              e.preventDefault();
              e.stopImmediatePropagation();
            });
            $(".resto-group").on('click', "#resto-zones-btn",function(e){
              $(this).next().toggle();
            });
            $(".resto-group").on('click', "#resto-zone-dropdown",function(e){
              e.stopPropagation();
            });

            //missing modal functions
            $("#options_modal").on('click','#missing-click',function(){
              $("#options_modal").modal('hide');
              $('#missing_modal').modal('show');
            });
            //mid is missing id, 1 is missing, 0 is not; submit
            $("#missing_modal").submit(function(e){
              var patient_id=$('.patient-id').val();
              var tooth_id=$('.tooth-id').val();
              $.post("includes/record/tooth-insert-missing.php",{pid:patient_id,tid:tooth_id,mid:1},function(){
                $("#missing_modal").modal('hide');
                getInitialChart(patient_id);
              });
              e.preventDefault();
              e.stopImmediatePropagation();
            });
            $("#change_missing_modal").submit(function(e){
              var patient_id=$('.patient-id').val();
              var tooth_id=$('.tooth-id').val();
              $.post("includes/record/tooth-insert-missing.php",{pid:patient_id,tid:tooth_id,mid:0},function(){
                $("#change_missing_modal").modal('hide');
                getInitialChart(patient_id);
              });
              e.preventDefault();
              e.stopImmediatePropagation();
            });

            
            $('.custom-nav-patient').on('click','#patient_treatment',function(e){
              $('.patient-nav').removeClass('active');
              $(this).addClass("active"); 
              $('.patient-nav-main').empty();
              var patient_treatment_id=$('.patient-nav-id').attr('id');
              getTreat(patient_treatment_id);
              e.stopImmediatePropagation();
            });
            //done
            $('.patient-nav-main').on('click','.patient-treatment-add',function(e){
              var treatment_id=$(this).attr('id');
              var pid=$('.patient-nav-id').attr('id');
              $.ajax({
                url:'includes/record/patient-treatment-add.php',
                data:{id:treatment_id},
                method:'POST',
                beforeSend:function(){
                  return confirm("Are you sure you want to tag this record as Done?");
                },
                success:function(response){
                  
                  $('.patient-nav-main').empty();
                  $('#message_modal').modal('show');
                  $("#message_modal_msg").empty();
                  $("#message_modal_msg").append('<p>'+ response +'</p>');
                  getTreat(pid);
                }
              });
              e.stopImmediatePropagation();
            });
            //delete
            $('.patient-nav-main').on('click','.patient-treatment-rm',function(e){
              var treatment_id=$(this).attr('id');
              var pid=$('.patient-nav-id').attr('id');
              $.ajax({
                url:'includes/record/patient-treatment-rm.php',
                data:{id:treatment_id},
                method:'POST',
                beforeSend:function(){
                  return confirm("Are you sure you remove this record?");
                },
                success:function(response){
                  $('.patient-nav-main').empty();
                  $('#message_modal').modal('show');
                  $("#message_modal_msg").empty();
                  $("#message_modal_msg").append('<p>'+ response +'</p>');
                  getTreat(pid);
                }
              });
              e.stopImmediatePropagation();
            });
            //////////////////////patient history//////////////////////
            $('.custom-nav-patient').on('click','#patient_history',function(e){
              $('.patient-nav').removeClass('active');
              $(this).addClass("active"); 
              $('.patient-nav-main').empty();
              var patient_history_id=$('.patient-nav-id').attr('id');
              getHistory(patient_history_id);
              e.stopImmediatePropagation();
            });
            //////////////////////patient files////////////////////
            $('.custom-nav-patient').on('click','#patient_files',function(e){
              $('.patient-nav').removeClass('active');
              $(this).addClass("active"); 
              $('.patient-nav-main').empty();
              var patient_id=$('.patient-nav-id').attr('id');
              getFiles(patient_id);
              e.stopImmediatePropagation();
            });

              //////////////////// file upload///////////////////
              $("#main-div").on('click',".item-image",function(){
                var patient_id=$('.patient-nav-id').attr('id');
                $("#upload_pid").val(patient_id);
                $("#fileUploadModal").modal('show');
                // $(".file-form").on('submit',function(e){
                //   var title=$('#image-title').val();
                //   $.ajax({
                //     url:'includes/record/patient-file-upload.php',
                //     data:{id:patient_id,title:title},
                //     type:'post',
                //     success:function(response){
                //       alert(response);
                //     }
                //   });
                //   e.preventDefault();
                // });
              });
              $("#main-div").on('click','.delete_image',function(e){
                var this_id=$(this).attr("id");
                $.ajax({
                  url:'includes/record/patient-file-delete.php',
                  method:'POST',
                  data:{id:this_id},
                  beforeSend:function(){
                    return confirm("Do you want to delete this file?");
                  },
                  success:function(response){
                    $('#message_modal').modal('show');
                    $("#message_modal_msg").empty();
                    $("#message_modal_msg").append('<p>'+ response +'</p>');
                    var patient_id=$('.patient-nav-id').attr('id');
                    getFiles(patient_id);
                  }
                });
                e.stopImmediatePropagation();
              });
              ///////////////////////////////////////////////////
            ////////////////////patient schedule

            $('.custom-nav-patient').on('click','#patient_schedule',function(e){
              $('.patient-nav').removeClass('active');
              $(this).addClass("active"); 
              $('.patient-nav-main').empty();
              var patient_schedule=$('.patient-nav-id').attr('id');
              getSchedule(patient_schedule);
              e.stopImmediatePropagation();
            });

            $(".patient-nav-main").on('click',".patient-schedule-done",function(e)
            {
              var id=$(this).attr("id");
              if(confirm("Are you sure you want to tag this schedule as Done?"))
              {
                $.post("includes/sched/sched-done.php",{id:id},function(data){
                    getSchedule(this_id);
                    $('#message_modal').modal('show');
                    $("#message_modal_msg").empty();
                    $("#message_modal_msg").append('<p>'+ data +'</p>');
                });
              }
            });
            $(".patient-nav-main").on('click',".patient-schedule-failed",function(e)
            {
              var id=$(this).attr("id");
              
              if(confirm("Are you sure you want to tag this schedule as No Show?"))
              {
                $.post("includes/sched/sched-failed.php",{id:id},function(data){
                    getSchedule(this_id);
                    $('#message_modal').modal('show');
                    $("#message_modal_msg").empty();
                    $("#message_modal_msg").append('<p>'+ data +'</p>');
                });
              }
            });
            $(".patient-nav-main").on('click',".patient-schedule-rm",function(e)
            {
              var id=$(this).attr("id");
              
              if(confirm("Are you sure you want to remove this schedule?"))
              {
                $.post("includes/sched/sched-delete.php",{id:id},function(data){
                    getSchedule(this_id);
                    $('#message_modal').modal('show');
                    $("#message_modal_msg").empty();
                    $("#message_modal_msg").append('<p>'+ data +'</p>');
                });
              }
            });
            ////////////////////////////
            //remove
            $('.patient-nav-main').on('click','.patient-history-rm',function(e){
              var history_id=$(this).attr('id');
              var pid=$('.patient-nav-id').attr('id');
              $.ajax({
                url:'includes/record/patient-treatment-rm.php',
                data:{id:history_id},
                method:'POST',
                beforeSend:function(){
                  return confirm("Are you sure you remove this record?");
                },
                success:function(response){
                  $('.patient-nav-main').empty();
                  $('#message_modal').modal('show');
                  $("#message_modal_msg").empty();
                  $("#message_modal_msg").append('<p>'+ response +'</p>');
                  getHistory(pid);
                }
              });
              e.stopImmediatePropagation();
            });
          });
          e.stopImmediatePropagation();
        });
        //////////////////////////////// patient_schedule

        //////////////////////////////////////
        //patient edit
        $('#main-div').on('click','.patient-edit-btn',function(e){
          var this_id=$(this).attr("id");
          $.get('includes/record/patient-form.php',function(modal){
            $('#main-div').html(modal);
            $.post("includes/record/patient-edit-fetch.php",{id:this_id},function(data){
              $("#firstname").val(data.fname);
              $("#lastname").val(data.lname);
              $("#address").val(data.address);
              $("#birthdate").val(data.birthdate);
              $("#email").val(data.email);
              $("#civil_status").val(data.civil_status);
              $("#occupation").val(data.occupation);
              $("#religion").val(data.religion);
              $("#notesarea").val(data.notes);
              $("#allergies").val(data.allergies);
              $("#contactno").val(data.contactno);
              $("#age").val(data.age);
              $("#patient_gender").val(data.sex);
              $("#patient_add_id").val(this_id);
              $("#pSave").val("Save");
              $("#pFormTitle").html("Edit Patient");
            },"json");
          });
        });

        //patient inactive
        $('#main-div').on('click','.patient-remove-btn',function(e){
          var this_id=$(this).attr("id");
          $.ajax({
            url:'includes/record/patient-delete.php',
            method:'POST',
            data:{id:this_id},
            beforeSend:function(){
              return confirm("Do you want to mark this patient as Inactive?");
            },
            success:function(response){
              $('#message_modal').modal('show');
              $("#message_modal_msg").empty();
              $("#message_modal_msg").append('<p>'+ response +'</p>');
              getInitialTable();
            }
          });
          e.stopImmediatePropagation();
        });

        //back to main table
        $('#main-div').on('click','#back-patientTbl',function(e){
          $("#main-div").empty();
          $('#main-div').load("pages/patients-table.php",function(){
            getInitialTable();
          });
          e.stopImmediatePropagation();
        });
      });
      
      $("#generate_monthly_report").on('click',function(){
         // $('#generate_report').on('click',function(){
          window.open('includes/report/generate-report.php','_blank');
        // });
      });
      $("#generate_appointment_report").on('click',function(){
        window.open('includes/report/generate-appointment-report.php','_blank');
      });


      
      //main calendar rendering and functions
      $("#sched_calendar").on("click", function(){
          $("#main-div").empty();
          $(".nav-items").removeClass("active");
          $(this).addClass("active"); 
          $("#main-div").load('pages/schedule_calendar.php',function(){

            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
              //PLEASE DO NOT TOUCH THESE CALENDAR PROPERTIES
                longPressDelay:500,
                initialView: 'listMonth',
                snapDuration:'00:05:00',
                slotDuration: '00:30:00',
                nowIndicator: true,
                headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                eventDisplay:'block',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                selectable: true,
                selectMirror: true,
                aspectRatio:1.6,
                dayMaxEvents: true, // allow "more" link when too many events
                contentHeight:"auto",
                eventConstraint:{
                  start:moment().format('YYYY-MM-DD'),
                  end:'9999-99-99'
                },
                views:{
                  dayGridMonth:{
                    dayMaxEvents:2
                  }
                },
                // events are handled by the load file and are passed via JSON encode
                // please refer to the loadEvents method from SchedModel.class
                events: 'includes/sched/load.php',
                eventColor:'#31c2b3',
                //get event data and show it on a pop-up modal
                select: 
                function(start, end, allDay){
                  var check = moment(start.start).format('YYYY-MM-DD');
                  var today = moment(new Date()).format('YYYY-MM-DD');
                  event_start=start;
                  if(check<today){
                    return false;
                  }
                  else
                  {
                    var startvar=moment(start.start).format('YYYY-MM-DD');
                    var time=moment(start.start).format('HH:mm');
                    $.get("includes/sched/existing.php",function(data){
                      $('.existing-nav').removeClass('active');
                      $("#existing-patient").addClass("active");
                      $('.addevent_modalbody').empty();
                      $('.addevent_modalbody').html(data);
                      $("#date").val(startvar);
                      $("#time").val(time);
                      $("#add_event_modal").modal("show");
                    });
                  }
                  
                },
                //update via resizing event in calendar
                eventResize:function(event){
                  var startvar=moment(event.event.start).format('Y-MM-DD HH:mm:ss');
                  var endvar=moment(event.event.end).format('Y-MM-DD HH:mm:ss');
                  var title = event.event.title;
                  var id = event.event.id;
                  $.ajax({
                    url:"includes/sched/update.php",
                    type:"POST",
                    data:{title:title, start:startvar, end:endvar, id:id},
                    success:function(e){
                      calendar.refetchEvents();
                      $('#message_modal').modal('show');
                      $("#message_modal_msg").empty();
                      $("#message_modal_msg").append('<p>'+ e +'</p>');
                    }
                  })
                },
                //
                //update via drag-n-drop
                eventDrop:function(event)
                {
                  var startvar=moment(event.event.start).format('Y-MM-DD HH:mm:ss');
                  var endvar=moment(event.event.end).format('Y-MM-DD HH:mm:ss');
                  var title = event.event.title;
                  var id = event.event.id;
                  $.ajax({
                      url:"includes/sched/update.php",
                      type:"POST",
                      data:{title:title, start:startvar, end:endvar, id:id},
                      success:function(e)
                      {
                        calendar.refetchEvents();
                        $('#message_modal').modal('show');
                        $("#message_modal_msg").empty();
                        $("#message_modal_msg").append('<p>'+ e +'</p>');
                      }
                    });
                },
                //deleting an event via clicking
                //TO-DO custom dialog
                eventClick:function(event)
                {
                  if(confirm("Are you sure you want to remove it?"))
                  {
                    var id = event.event.id;
                    $.ajax({
                      url:"includes/sched/delete.php",
                      type:"POST",
                      data:{id:id},
                      success:function(e)
                      {
                        calendar.refetchEvents();
                        $('#message_modal').modal('show');
                        $("#message_modal_msg").empty();
                        $("#message_modal_msg").append('<p>'+ e +'</p>');
                      }
                    })
                  }
                }
            });
          
          calendar.render();
          $("#main-div").append('<br>');
          });
          // $("#main-div").append('<div class="row"><div class="col-md-12"><h4>Schedule Calendar</h4></div>');
          // $("#main-div").append('<div id="calendar"></div>');


      });
      
      


      // existing on click
      $('.custom-nav-existing').on('click','#existing-patient',function(e){              
        $('.existing-nav').removeClass('active');
        $(this).addClass("active");
        $.get("includes/sched/existing.php",function(data){
          $('.addevent_modalbody').empty();
          $('.addevent_modalbody').html(data);
          var startvar=moment(event_start.start).format('YYYY-MM-DD');
          var time=moment(event_start.start).format('HH:mm');
          $("#date").val(startvar);
          $("#time").val(time);
        });
        e.stopImmediatePropagation();
      });
      $('.custom-nav-existing').on('click','#new-patient',function(e){
        $('.existing-nav').removeClass('active');
        $(this).addClass("active"); 
        $.get("includes/sched/new.php",function(data){
          $('.addevent_modalbody').empty();
          $('.addevent_modalbody').html(data);
          var startvar=moment(event_start.start).format('YYYY-MM-DD');
          var time=moment(event_start.start).format('HH:mm');
          $("#date").val(startvar);
          $("#time").val(time);
        });
        e.stopImmediatePropagation();
      });
      
      //add event controller/data gatherer
      
      $("#add_event_modal").submit(function(e){
        var patient_type=$("#patient_type").val();
        if(patient_type==1)
        {
          var name=$("#existing-datalist").val();
          var id=$("#existingOptions option[value='"+name+"']").attr('id');
          var date= $("#date").val();
          var time =$("#time").val();
          var start_event = moment(date + ' ' + time).format("YYYY-MM-DD HH:mm:ss");
          var get_end_event=moment(start_event, "YYYY-MM-DD HH:mm:ss").add(3,"hours");
          var end_event=moment(get_end_event).format("YYYY-MM-DD HH:mm:ss");
          if(name)
          {
            $.ajax({
              url:"includes/sched/insert.php",
              type:"POST",
              data:{title:name, start:start_event, end:end_event, id:id},
              success:function(e)
              {
                $("#add_event_modal").modal('hide');
                $('#add_event_modal').on('hidden.bs.modal',function(){
                  $(this).find('form')[0].reset();
                });
                calendar.refetchEvents();
                $('#message_modal').modal('show');
                $("#message_modal_msg").empty();
                $("#message_modal_msg").append('<p>'+ e +'</p>');
              }
            });
          }
        }
        else if(patient_type==2)
        {
          var fname=$("#fname").val();
          var lname=$("#lname").val();
          var name=fname+" "+lname;
          var contact=$("#contact").val();
          var date= $("#date").val();
          var time =$("#time").val();
          var start_event = moment(date + ' ' + time).format("YYYY-MM-DD HH:mm:ss");
          var get_end_event=moment(start_event, "YYYY-MM-DD HH:mm:ss").add(3,"hours");
          var end_event=moment(get_end_event).format("YYYY-MM-DD HH:mm:ss");
          if(name)
          {
            $.ajax({
              url:"includes/sched/insert-new.php",
              type:"POST",
              data:{fname:fname, lname:lname, contact:contact,title:name, start:start_event, end:end_event},
              success:function(e)
              {
                $("#add_event_modal").modal('hide');
                $('#add_event_modal').on('hidden.bs.modal',function(){
                  $(this).find('form')[0].reset();
                });
                calendar.refetchEvents();
                $('#message_modal').modal('show');
                $("#message_modal_msg").empty();
                $("#message_modal_msg").append('<p>'+ e +'</p>');
              }
            });
          }
        }
        e.preventDefault();
      });
      




      //request table view
      $("#app-requests").off("click").on("click",function(){
        $("#main-div").empty();
        $(".nav-items").removeClass("active");
        $(this).addClass("active"); 

        //set all scripts after loading the page to prevent depreciation
        $('#main-div').load("pages/request-table.php",function(){
          getInitialReqTable();
          
          $('#main-div').on('keyup','#search-appointment-field',function(e){
            var input=$(this).val();
            $.post("includes/request/request-page-fetch.php",{input:input},function(data){
              $('.appointment-main').html(data);
            });
            e.stopImmediatePropagation();
          });
        });

        $("#main-div").on("click",".reject-btn",function(e){
          var this_id= $(this).attr("id");
          $.ajax({
              url:"includes/request/request-delete.php",
              method:"POST",
              data:{id:this_id},
              beforeSend:function(){  
                  return confirm("Do you want to reject this request?");
              },
              success:function(e){
                  $("#message_modal_msg").empty();
                  $("#message_modal_msg").append('<p>'+ e +'</p>');
                  $('#message_modal').modal('show');
                  $('#main-div').load("pages/request-table.php",function(){
                    getInitialReqTable();
                  });
              }
          });
          e.stopImmediatePropagation();
        });

        $("#main-div").on("click",".accept-btn",function(){
          var this_id= $(this).attr("id");
          $.get("includes/request/request-existing.php",function(data){
            $('.req-existing-nav').removeClass('active');
            $("#req-existing-patient").addClass("active");
            $('.addrequest_modalbody').empty();
            $('.addrequest_modalbody').html(data);
          });
          
          $.ajax({
              url:"includes/request/request-fetch.php",
              method:"POST",
              data:{id:this_id},
              dataType:"json",
              success: function(data){
                  var date_serial=moment(data.start).format("YYYY-MM-DD");
                  $("#rentry_id").val(data.id);
                  $("#rdate").val(date_serial);
                  $("#rnumber").val(data.email);
              }
          });

          $('#add_request_modal').modal('show');
          
          $('.custom-nav-existing').on('click','#req-existing-patient',function(e){              
            $('.req-existing-nav').removeClass('active');
            $(this).addClass("active");
            requestExisting();
            $.ajax({
                url:"includes/request/request-fetch.php",
                method:"POST",
                data:{id:this_id},
                dataType:"json",
                success: function(data){
                    var date_serial=moment(data.start).format("YYYY-MM-DD");
                    $("#rentry_id").val(data.id);
                    $("#rdate").val(date_serial);
                    $("#rnumber").val(data.email);
                }
            });
            e.stopImmediatePropagation();
          });
          


          $('.custom-nav-existing').on('click','#req-new-patient',function(e){              
            $('.req-existing-nav').removeClass('active');
            $(this).addClass("active");
            requestNew();
              $.ajax({
                url:"includes/request/request-fetch.php",
                method:"POST",
                data:{id:this_id},
                dataType:"json",
                success: function(data){
                    var date_serial=moment(data.start).format("YYYY-MM-DD");
                    $("#rentry_id").val(data.id);
                    $("#rdate").val(date_serial);
                    $("#rnumber").val(data.email);
                    $("#rfname").val(data.fname);
                    $("#rlname").val(data.lname);
                }
            });
            e.stopImmediatePropagation();
          });
          
        });
        $("#add_request_modal").submit(function(e){
            var req_id=$("#rentry_id").val();
            var patient_type=$("#reqpatient_type").val();
            if(patient_type==1)
            {
              var title=$("#req-existing-datalist").val();
              var id=$("#reqexistingOptions option[value='"+title+"']").attr('id');
              var date= $("#rdate").val();
              var time =$("#rtime").val();
              var start_event = moment(date + ' ' + time).format("YYYY-MM-DD HH:mm:ss");
              var get_end_event=moment(start_event, "YYYY-MM-DD HH:mm:ss").add(3,"hours");
              var end_event=moment(get_end_event).format("YYYY-MM-DD HH:mm:ss");
              var contactno=$("#rnumber").val();
              var notify=$("#rnotify:checked").val();
              $.ajax({
                type:'POST',
                url:'includes/request/request-accept-existing.php',
                data:{req_id:req_id,id:id,name:title,start_event:start_event,end_event:end_event,contactno:contactno,notify:notify},
                success: function(e){
                    $('#message_modal').modal('show');
                    $("#message_modal_msg").empty();
                    $("#message_modal_msg").append('<p>'+ e +'</p>');
                    $('#add_request_modal').modal('hide');
                    $('#main-div').load("pages/request-table.php",function(){
                      getInitialReqTable();
                    });
                }
              });
              
            }
            else if(patient_type==2)
            {
              var rfname=$("#rfname").val();
              var rlname=$("#rlname").val();
              var contact=$("#rnumber").val();
              var date= $("#rdate").val();
              var time =$("#rtime").val();
              var start_event = moment(date + ' ' + time).format("YYYY-MM-DD HH:mm:ss");
              var get_end_event=moment(start_event, "YYYY-MM-DD HH:mm:ss").add(3,"hours");
              var end_event=moment(get_end_event).format("YYYY-MM-DD HH:mm:ss");
              var notify=$("#rnotify:checked").val();
              $.ajax({
                type:'POST',
                url:'includes/request/request-accept-new.php',
                data:{req_id:req_id,fname:rfname,lname:rlname,start_event:start_event,end_event:end_event,contact:contact,notify:notify},
                success: function(e){
                    $('#message_modal').modal('show');
                    $("#message_modal_msg").empty();
                    $("#message_modal_msg").append('<p>'+ e +'</p>');
                    $('#add_request_modal').modal('hide');
                    $('#main-div').load("pages/request-table.php",function(){
                      getInitialReqTable();
                    });
                }
              });
            }
            e.preventDefault();
            e.stopImmediatePropagation();
        });



        /////////////////// appointment existing///////////////



      function requestExisting()
      {
        $.get("includes/request/request-existing.php",function(data){
          $('.addrequest_modalbody').empty();
          $('.addrequest_modalbody').html(data);
        });
      }

      function requestNew()
      {
        $.get("includes/request/request-new.php",function(data){
          $('.addrequest_modalbody').empty();
          $('.addrequest_modalbody').html(data);
        });
      }
      ///////////////////////////////////////////////////////


      });

      $("#settings").on("click",function(){
        $("#main-div").empty();
        $(".nav-items").removeClass("active");
        $(this).addClass("active"); 
        loadSettings();
        $('#main-div').on('submit','.smsapi',function(e){
          var apicode=$('#apicode').val();
          var apipasswd=$('#apipasswd').val();
          $.post("includes/settings/settings_update.php",{apicode:apicode,apipasswd:apipasswd,save:""},function(response){
            $('#message_modal').modal('show');
            $("#message_modal_msg").empty();
            $("#message_modal_msg").append('<p>'+ response +'</p>');
            loadSettings();
          });
          e.preventDefault();
        });
        getSettings();

        $('#main-div').on('change','#dmtoggle',function(e){
          var mode=$("input:checkbox[name='dmtoggle']:checked").val();
          $.post("includes/settings/darkmode-toggle.php",{mode:mode},function(response){
            alert(response);
            location.reload(true);
          });
        });
      });

      $.get("includes/settings/get_settings.php",function(response){
        init(response);
      });
      function getSettings()
      {
        $.get("includes/settings/get_settings.php",function(response){
          if(response=="dark")
          {
            document.getElementById("dmtoggle").checked = true;
          }
        });
      }
      function swapStyleSheet(sheet){
        document.getElementById("app-theme").setAttribute("href", sheet); 
      }
    
      function init(mode)
      {
          if(mode=="dark")
          {
              swapStyleSheet("css/admin-style-dark.css");
          }
          else if(mode=="default")
          {
              swapStyleSheet("css/admin-style.css");
          }
      }

      function loadSettings()
      {
        $("#main-div").load("pages/sms-status-page.php");
        $.get("includes/sms/sms-status.php",function(data)
        {
          $('#maxmsg').html(data['Result ']['MaxMessages']);
          $('#msgleft').html(data['Result ']['MessagesLeft']);
          $('#expidate').html(moment(data['Result ']['ExpiresOn']).format('MMM D, YYYY'));
          
        },"json");
        $.get("includes/sms/sms-outgoing.php",function(data)
        {
         $('#outgoing').html(data['result']['count']); 
        },"json");
        $.get("includes/settings/settings_form.php",function(data){
          $('.api-settings').html(data);
        });
      }

      //////////////////////////// CLINIC /////////////////////////////////////////
      $('#clinic-procedures').on('click',function(){
        $("#main-div").empty();
        $(".nav-items").removeClass("active");
        $(this).addClass("active"); 
        initProcPage();
        
        $('#main-div').on('click','#proc_tbl',function(e){
          $('.proc-nav').removeClass('active');
          $(this).addClass("active"); 
          $('.procedure-nav-main').empty();
          initProcTable();
          e.stopImmediatePropagation();
        });
        $('#main-div').on('click','#branch_tbl',function(e){
          $('.proc-nav').removeClass('active');
          $(this).addClass("active"); 
          $(".procedure-nav-main").empty();
          initBranchTable();
          e.stopImmediatePropagation();
        })
      });


      ////////////////////////////////////// major update

      $("#manage-list").on("click",function(){
        $("#main-div").empty();
        $(".nav-items").removeClass("active");
        $(this).addClass("active"); 
        initUserTable();

        $('#main-div').on('click','.user-role-edit',function(e){
          $('#addUserForm')[0].reset();
          var this_id= $(this).attr("id");
          $.post("includes/usermanagement/user-fetch.php",{this_id:this_id},function(data){
            $("#user_id").val(this_id);
            $("#username").val(data);
            $('#user_role_modal').modal('show');
          });
          e.stopImmediatePropagation();
        });

        $('#main-div').on('submit','.userRoleForm',function(e){
          var user_id=$("#user_id").val();
          var user_role=$(".user-role-select option:selected").val();
            $('#user_role_modal').modal('hide');
          $.post("includes/usermanagement/user-role-edit.php",{user_id:user_id,user_role:user_role},function(e){
            $('#message_modal').modal('show');
            $("#message_modal_msg").empty();
            $("#message_modal_msg").append('<p>'+ e +'</p>');
          });
          
          initUserTable();
          e.stopImmediatePropagation();
          e.preventDefault();
        });

        $('#main-div').on('click','.user-remove',function(e){
          var this_id= $(this).attr("id");
          $.ajax({
            url:'includes/usermanagement/user-remove.php',
            type:'POST',
            data:{this_id:this_id},
            beforeSend:function(){
              return confirm("Are you sure you want to remove this user?");
            },
            success:function(message){
              $('#message_modal').modal('show');
              $("#message_modal_msg").empty();
              $("#message_modal_msg").append('<p>'+ message +'</p>');
              initUserTable();
            }
          });
          e.stopImmediatePropagation();
        });

        //////////////////////////////////
        $('#main-div').on('click','#add-user-btn',function(e){
          $('#userRoleForm')[0].reset();
          $('#add_user_modal').modal('show');
          e.stopImmediatePropagation();
        });
        

        ///////////////////////////////////////
        $('#main-div').on('click','#pass_eye_toggle',function(){
          passToggle('passwordadd','pass_eye_toggle');
          passToggle('confirmpasswordadd','pass_eye_toggle');
        });

        /////////////////////////////////////////
        $('#main-div').on('submit','.addUserForm',function(e){
          var username=$("#usernameadd").val();
          var password=$("#passwordadd").val();
          var email=$("#useremail").val();
          var user_role=$(".user-role-select-add option:selected").val();
          $.ajax({
            url:'includes/usermanagement/user-add.php',
            type:'POST',
            data:{username:username,password:password,user_role:user_role,email:email},
            beforeSend:function(){
              return confirm("Are you sure you want to add this user?");
            },
            success:function(message){
              $('#add_user_modal').modal('hide');
              $('#message_modal').modal('show');
              $("#message_modal_msg").empty();
              $("#message_modal_msg").append('<p>'+ message +'</p>');
              initUserTable();
            }
          })
          e.stopImmediatePropagation();
          e.preventDefault();
        })
      });

      $("#manage-role").on("click",function(e){
        $("#main-div").empty();
        $(".nav-items").removeClass("active");
        $(this).addClass("active"); 
        $('#main-div').load("pages/roles-table.php");

        // edit-btn
        $("#main-div").on("click",".manage-role-edit",function(e){
          var this_id= $(this).attr("id");
          $("#main-div").load("includes/usermanagement/role-edit-fetch.php",{id:this_id},function(){
            
            //sumbit role update
            $("#main-div").on("submit","#permissions_form",function(e){
              
              var uid=$(".user-perm-desc").attr("id");
              var role_desc=$(".user-perm-desc").val();
              var clinic_profile=$("input:radio[name='clinic_profile']:checked").val();
              var clinic_medications=$("input:radio[name='clinic_medications']:checked").val();
              var clinic_procedures=$("input:radio[name='clinic_procedures']:checked").val();
              var patient_records=$("input:radio[name='patient_records']:checked").val();
              var schedule_calendar=$("input:radio[name='schedule_calendar']:checked").val();
              var appointment_requests=$("input:radio[name='appointment_requests']:checked").val();
              var user_management=$("input:radio[name='user_management']:checked").val();
              var settings=$("input:radio[name='settings']:checked").val();

              var clinic_prof_view;var clinic_prof_edit;var clinic_med_view;var clinic_med_edit;
              var clinic_proc_view;var clinic_proc_edit;var patient_rec_view;var patient_rec_edit;
              var sched_cal_view;var sched_cal_edit;var app_req_view;var app_req_edit;
              var user_manage_view;var user_manage_edit;var settings_view;var settings_edit;

              /////set clinic profile
              if(clinic_profile==2)
              {
                clinic_prof_view=1;clinic_prof_edit=1;
              }
              else if(clinic_profile==1)
              {
                clinic_prof_view=1;clinic_prof_edit=0;
              }
              else if(clinic_profile==0)
              {
                clinic_prof_view=0;clinic_prof_edit=0;
              }

              /////set clinic meds
              if(clinic_medications==2)
              {
                clinic_med_view=1;clinic_med_edit=1;
              }
              else if(clinic_medications==1)
              {
                clinic_med_view=1;clinic_med_edit=0;
              }
              else if(clinic_medications==0)
              {
                clinic_med_view=0;clinic_med_edit=0;
              }

              /////set clinic procedures
              if(clinic_procedures==2)
              {
                clinic_proc_view=1;clinic_proc_edit=1;
              }
              else if(clinic_procedures==1)
              {
                clinic_proc_view=1;clinic_proc_edit=0;
              }
              else if(clinic_procedures==0)
              {
                clinic_proc_view=0;clinic_proc_edit=0;
              }


              /////set patient records
              if(patient_records==2)
              {
                patient_rec_view=1;patient_rec_edit=1;
              }
              else if(patient_records==1)
              {
                patient_rec_view=1;patient_rec_edit=0;
              }
              else if(patient_records==0)
              {
                patient_rec_view=0;patient_rec_edit=0;
              }
              
              /////set schedule calendar
              if(schedule_calendar==2)
              {
                sched_cal_view=1;sched_cal_edit=1;
              }
              else if(schedule_calendar==1)
              {
                sched_cal_view=1;sched_cal_edit=0;
              }
              else if(schedule_calendar==0)
              {
                sched_cal_view=0;sched_cal_edit=0;
              }
              
              
              /////set appointment request
              if(appointment_requests==2)
              {
                app_req_view=1;app_req_edit=1;
              }
              else if(appointment_requests==1)
              {
                app_req_view=1;app_req_edit=0;
              }
              else if(appointment_requests==0)
              {
                app_req_view=0;app_req_edit=0;
              }
              
              
              /////set user_management
              if(user_management==2)
              {
                user_manage_view=1;user_manage_edit=1;
              }
              else if(user_management==1)
              {
                user_manage_view=1;user_manage_edit=0;
              }
              else if(user_management==0)
              {
                user_manage_view=0;user_manage_edit=0;
              }
              
              /////set settings
              if(settings==2)
              {
                settings_view=1;settings_edit=1;
              }
              else if(settings==1)
              {
                settings_view=1;settings_edit=0;
              }
              else if(settings==0)
              {
                settings_view=0;settings_edit=0;
              }
              /// insert script
              $.ajax({
                type:'POST',
                url:'includes/usermanagement/role-edit.php',
                data:{
                  uid:uid,
                  role_desc:role_desc,
                  clinic_prof_view:clinic_prof_view,
                  clinic_prof_edit:clinic_prof_edit,
                  clinic_med_view:clinic_med_view,
                  clinic_med_edit:clinic_med_edit,
                  clinic_proc_view:clinic_proc_view,
                  clinic_proc_edit:clinic_proc_edit,
                  patient_rec_view:patient_rec_view,
                  patient_rec_edit:patient_rec_edit,
                  sched_cal_view:sched_cal_view,
                  sched_cal_edit:sched_cal_edit,
                  app_req_view:app_req_view,
                  app_req_edit:app_req_edit,
                  user_manage_view:user_manage_view,
                  user_manage_edit:user_manage_edit,
                  settings_view:settings_view,
                  settings_edit:settings_edit
                },
                success:function(e)
                {
                  $('#message_modal').modal('show');
                  $("#message_modal_msg").empty();
                  $("#message_modal_msg").append('<p>'+ e +'</p>');
                }
              });
              
              e.preventDefault();
              e.stopImmediatePropagation();
            });
            //go back to previous 
            $("#main-div").on('click','#permission_cancel',function(e){
              $('#main-div').load("pages/roles-table.php");
              e.stopImmediatePropagation();
            });
          });
        });
        e.stopImmediatePropagation();
      });

      //////////// new update feb 25
      function existingPatient()
      {
        $.get("includes/sched/existing.php",function(data){
          $('.addevent_modalbody').html(data);
        });
      }

      function initProcPage()
      {
        $('#main-div').load("pages/clinic-procedures-page.php",function(){
          initProcTable();
        });
      }

      function initProcTable()
      {
        $('.procedure-nav-main').load("pages/clinic-procedures-tbl.php",function(){
          
          $.post("includes/clinic/branch-select.php",{isadd:0},function(data){
            $('.clinic-branch-group').append(data);
          });
          $.post("includes/clinic/branch-select.php",{isadd:1},function(data){
            $('.clinic-branch-group-add').append(data);
          });

          $('#main-div').on('click','#add-proc-btn',function(e){
            $('#procEditForm')[0].reset();
            $('#clinic_proc_modal').modal('show');
            e.stopImmediatePropagation();
          });
          //////////submit
          $('#main-div').on('submit','.clinicProcForm',function(e){
            var procedure_name=$("#procname").val();
            var branch_id=$(".clinic-branch-select-add option:selected").val();
            $('#clinic_proc_modal').modal('hide');
            $.post("includes/clinic/add-procedure.php",{procedure_name:procedure_name,branch_id:branch_id},function(e){
              $('#message_modal').modal('show');
              $("#message_modal_msg").empty();
              $("#message_modal_msg").append('<p>'+ e +'</p>');
            });
            
            initProcTable();
            e.stopImmediatePropagation();
            e.preventDefault();
          });

          /////// remove
          $('#main-div').on('click','.proc-remove',function(e){
            var this_id= $(this).attr("id");
            $.ajax({
              url:'includes/clinic/remove-procedure.php',
              type:'POST',
              data:{this_id:this_id},
              beforeSend:function(){
                return confirm("Are you sure you want to remove this procedure?");
              },
              success:function(message){
                $('#message_modal').modal('show');
                $("#message_modal_msg").empty();
                $("#message_modal_msg").append('<p>'+ message +'</p>');
                initProcTable();
              }
            });
            e.stopImmediatePropagation();
          })
          ///// edit
          $('#main-div').on('click','.proc-edit',function(e){
              $('#clinicProcForm')[0].reset();
              var this_id= $(this).attr("id");
              $.post("includes/clinic/procedure-fetch.php",{this_id:this_id},function(data){
                $("#proc_user_id").val(this_id);
                $("#editprocname").val(data);
                $('#proc_edit_modal').modal('show');
              });
              e.stopImmediatePropagation();
          });

          $('#main-div').on('submit','.procEditForm',function(e){
            var proc_id=$('#proc_user_id').val();
            var proc_name=$('#editprocname').val();
            var branch_id=$(".clinic-branch-select option:selected").val();
            $('#proc_edit_modal').modal('hide');
            $.post("includes/clinic/edit-procedure.php",{proc_id:proc_id,proc_name:proc_name,branch_id:branch_id},function(e){
              $('#message_modal').modal('show');
              $("#message_modal_msg").empty();
              $("#message_modal_msg").append('<p>'+ e +'</p>');
              initProcTable();
            });
            e.stopImmediatePropagation();
            e.preventDefault();
          });
          
        });
      }

      function initBranchTable()
      {
        $('.procedure-nav-main').load("pages/clinic-branches-tbl.php",function(){
          $('#main-div').on('click','#add-branch-btn',function(e){
            $('#clinic_branch_modal').modal('show');
          });

          $('#main-div').on('submit','.clinicBranchForm',function(e){
            var branch_name=$('#branchname').val();
            $('#clinic_branch_modal').modal('hide');
            $.post("includes/clinic/add-branch.php",{branch_name:branch_name},function(e){
              initBranchTable();
              $('#message_modal').modal('show');
              $("#message_modal_msg").empty();
              $("#message_modal_msg").append('<p>'+ e +'</p>');
            });
            e.stopImmediatePropagation();
            e.preventDefault();
          });

          $('#main-div').on('click','.branch-remove',function(e){
            var this_id=$(this).attr('id');
            $.ajax({
              url:'includes/clinic/remove-branch.php',
              type:'POST',
              data:{this_id:this_id},
              beforeSend:function(){
                return confirm("Are you sure you want to remove this branch?");
              },
              success:function(message){
                $('#message_modal').modal('show');
                $("#message_modal_msg").empty();
                $("#message_modal_msg").append('<p>'+ message +'</p>');
                initBranchTable();
              }
            });
            e.stopImmediatePropagation();
          });

          $('#main-div').on('click','.branch-edit',function(e){
              $('#clinicBranchForm')[0].reset();
              var this_id= $(this).attr("id");
              $.post("includes/clinic/edit-branch-fetch.php",{this_id:this_id},function(data){
                $("#branchuser_id").val(this_id);
                $("#editbranchname").val(data);
                $('#branch_edit_modal').modal('show');
              });
              e.stopImmediatePropagation();
          });

          $('#main-div').on('submit','.branchEditForm',function(e){
            var this_id=$("#branchuser_id").val();
            var branch_name=$('#editbranchname').val();
            $('#branch_edit_modal').modal('hide');
            $.post("includes/clinic/edit-branch.php",{this_id:this_id,branch_name:branch_name},function(e){
              $('#message_modal').modal('show');
              $("#message_modal_msg").empty();
              $("#message_modal_msg").append('<p>'+ e +'</p>');
              initBranchTable();
            });
            e.stopImmediatePropagation();
            e.preventDefault();
          });
        });
      }
      //////////////////////////////////////

      function initUserTable()
      {
        $('#main-div').load("pages/users-table.php",function(){
          $.post("includes/usermanagement/user-role-select.php",{isadd:0},function(data){
            $('.user-role-group').append(data);
          });
          $.post("includes/usermanagement/user-role-select.php",{isadd:1},function(data){
            $('.user-role-group-add').append(data);
          });
          formValidation();
        });
      }
      
      function formValidation()
      {
        $('#addUserForm').validate({ // initialize the plugin
          rules: {
              usernameadd: {
                  required: true,
                  minlength: 8,
                  remote:"includes/usermanagement/username-check.php"
              },
              useremail:{
                  required:true,
                  email:true,
                  remote:"includes/usermanagement/email-check.php"
              },
              passwordadd: {
                  required: true,
                  minlength: 8
              },
              confirmpasswordadd:{
                  required:true,
                  equalTo:'#passwordadd'
              }
          },
            messages:{
              usernameadd: {
                required: "*Please enter a username",
                minlength:"Username should be 8 characters long!",
                remote:"Username is already taken"
            },
            useremail:{
                required:"*Please enter an email",
                email:"*Please enter a valid email address",
                remote:"Email already exists"
            },
            passwordadd: {
                required: "*Please enter a password",
                minlength: "Password should be 8 characters long!"
            },
            confirmpasswordadd:{
                required:"*Please confirm password",
                equalTo:"Password do not match!"
            },
            onkeyup: false,
            onblur: true
          }
        });
      }

      function passToggle(element,toggle) {
        var x = document.getElementById(element);
        var y=document.getElementById(toggle);
        var slashy=document.createElement('i');
        slashy.className='bi bi-eye-slash-fill';
        var normal=document.createElement('i');
        normal.className='bi bi-eye';
        if (x.type === "password") {
          x.type = "text";
          y.removeChild(y.childNodes[0]);
          y.appendChild(slashy);
        } else {
          x.type = "password";
          y.removeChild(y.childNodes[0]);
          y.appendChild(normal);
        }
      } 
      //////////////////////////////////////////////////////
      //patient add or edit
      function patientAdd(id,method)
      {
        // console.log($(".patientForm").serialize()+'&id='+id+'&method='+method);
        $.post("includes/record/patient-add.php",$(".patientForm").serialize()+'&id='+id+'&method='+method,function(msg){
          // alert(msg);
          $('#message_modal').modal('show');
          $("#message_modal_msg").empty();
          $("#message_modal_msg").append('<p>'+ msg +'</p>');
          // $("#patientForm")[0].reset();
          patientRecords();
        });
      }
      function patientRecords()
      {
        $('#main-div').load("pages/patients-table.php",function(){
          getInitialTable();
        });
      }
      //setting minimum date;
      function setDateMin(date_var)
      {
        $.ajax({
          url:'includes/minDate.php',
          type:'GET',
          dataType:'json',
          success: function(data){
            $(date_var).attr("min",data);
          }
        });
      }
      setDateMin("#date");
      function getTeethOperations()
      {
        $.get("../includes/service-fetch.php",function(data,status){
          $('#test-select').append(data);
        });
      }
      function getInitialTable()
      {
        $.get('includes/record/patient-page-fetch.php',function(data,success){
          $('.patient-table').html(data);
        });
      }
      function getInitialReqTable()
      {
        $.get('includes/request/request-page-fetch.php',function(data,success){
          $('.appointment-main').html(data);
        });
      }
      function getInitialChart(this_id)
      {
        $.post("includes/record/patient-nav-chart.php",{id:this_id},function(data){
          $('.patient-nav-main').html(data);
        });
      }
      function getInitialProc(method_id)
      {
        if(method_id==1)
        {
          $.post("includes/record/get-procedure.php",{method:method_id},function(data){
            $('.patho-group').append(data);
          });
        }
        else if(method_id==2)
        {
          $.post("includes/record/get-procedure.php",{method:method_id},function(data){
            $('.resto-group').append(data);
          });
        }
        else if(method_id==3)
        {
          $.post("includes/record/get-procedure.php",{method:method_id},function(data){
            $('.other-group').append(data);
          });
        }
      }
      function loader(){
        $(window).on('load',function(){
          $('.main-loader').fadeOut(1000);
          $('.main-content').fadeIn(1000);
        });
      }
      function getTreat(this_id)
      {
        $.post("includes/record/patient-treatment.php",{id:this_id},function(data){
          $('.patient-nav-main').html(data);
        });
      }
      function getHistory(this_id)
      {
        $.post("includes/record/patient-history.php",{id:this_id},function(data){
          $('.patient-nav-main').html(data);
        });
      }
      function getFiles(this_id)
      {
        $.post("includes/record/patient-files.php",{id:this_id},function(data){
          $('.patient-nav-main').html(data);
        });
      }
      function getSchedule(this_id)
      {
        $.post("includes/record/patient-schedule.php",{id:this_id},function(data){
          $('.patient-nav-main').html(data);
        });
      }
      function sendSMS(contactno,message)
      {
        $.post("../includes/sms/sms-send.php",{contactno,message},function(response){
          alert(response);
        });
      }
      
      function dashboardCharts()
      {
        $.post("includes/dashboard/chart-patient-data.php",function(data)
        {
          var label=[];
          var total=[];
          for(var count=0;count<data.length;count++)
          {
            label.push(data[count].month);
            total.push(data[count].count);
          }

          var chart_data={
            labels:label,
            datasets:[
              {
                label:'# of new Patients',
                backgroundColor:'#31c2b3',
                color:'#31c2b3',
                data:total
              }
            ]
          }

          var options={
            responsive:true,
            scales:{
              yAxes:[{
                ticks:{
                  min:0
                }
              }]
            }
          }

          var group_chart1=$('.monthlygrowth-datachart');
          var myChart=new Chart(group_chart1,{
            type:'line',
            data:chart_data
          })
        },'JSON');
        $.post("includes/dashboard/chart-operation-data.php",function(data)
        {
          var label=[];
          var value=[];
          for(var count=0;count<5;count++)
          {
            label.push(data[count].procname);
            value.push(data[count].total);
          }

          var chart_data={
            labels:label,
            datasets:[
              {
                label:'# of Operations',
                backgroundColor:'#31c2b3',
                color:'r#31c2b3',
                data:value
              }
            ]
          }

          var options={
            responsive:true,
            scales:{
              yAxes:[{
                ticks:{
                  min:0
                }
              }]
            }
          }

          var group_chart1=$('.operations-datachart');
          var myChart=new Chart(group_chart1,{
            type:'bar',
            data:chart_data
          });
        },'JSON');
        $.post("includes/dashboard/chart-gender-data.php",function(data){
          var label=["Male","Female","Other"];
          // console.log(data);
          var genders=[];
          if(data[0]==0 && data[1]==0 && data[2]==0)
          {
            genders=[1,1,1];
          }
          else
          {
            for(var count=0;count<data.length;count++)
            {
              genders.push(data[count]);
            }
          }
          var chart_data_gender={
            labels:label,
            datasets:[
              {
                label:'# of Operations',
                backgroundColor:['#8fbaff','#ffb8fd','#942673'],
                color:'#31c2b3',
                data:genders
              }
            ]
          }
          var options={
            responsive:false,
            scales:{
              yAxes:[{
                ticks:{
                  min:0
                }
              }]
            },
            maintainAspectRatio: false
          }
          var group_chart1=$('.gender-datachart');
          var myChart=new Chart(group_chart1,{
            type:'pie',
            data:chart_data_gender
          });
          },'JSON');


          $.post("includes/dashboard/gender-ratio-data.php",function(data)
          {
  
            var chart_data={
              labels:["7-15","16-25","26-35","36-45","56-65","65+"],
              datasets:[
                {
                  label:'Male',
                  backgroundColor:'#8fbaff',
                  color:'r#31c2b3',
                  data:data[0]
                },
                {
                  label:'Female',
                  backgroundColor:'#ffb8fd',
                  color:'r#31c2b3',
                  data:data[1]
                },
                {
                  label:'Other',
                  backgroundColor:'#942673',
                  color:'r#31c2b3',
                  data:data[2]
                }
              ]
            }
  
            var options={
              responsive:false,
              scales:{
                yAxes:[{
                  ticks:{
                    min:0
                  }
                }]
              }
            }
  
            var group_chart1=$('.age-datachart');
            var myChart=new Chart(group_chart1,{
              type:'bar',
              data:chart_data
            });
          },'JSON');
      }
      
      function initializeTooltips()
      {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
      }
});