<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
if (!isset($_SESSION)) {
    session_start();
    if (!($_SESSION['email'] && $_SESSION['email_key'] && $_SESSION['loginMode'])) {
        session_destroy();

        header("Location: home.php"); //redirect to login page to secure the welcome page without login access.
    }
}
include_once 'dbconfig/dbconfig.php';
?>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>KS Hospital Management</title>


        <?php include "pagelayout/navbar.php" ?>
    </head>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/chat.css">
    <link rel="stylesheet" href="assets/css/dropdown/bootstrap-select.css">

    <body>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Today's Appointments</h3></div>
                        <div id="todays_app" class="panel-body">
                            <div id="todays_list_view" class="List_view chat_list_view">
                                <ul class="chat" id="1"></ul>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Today's Calender</h3></div>
                        <div id="todays_app" class="panel-body">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr class="success">
                                                <th>Column 1</th>
                                                <th>Column 2</th>
                                                <th>Column 2</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Cell 1</td>
                                                <td>Cell 2</td>
                                                <td>Cell 2</td>
                                            </tr>
                                            <tr>
                                                <td>Cell 3</td>
                                                <td>Cell 4</td>
                                                <td>Cell 4</td>
                                            </tr>
                                            <tr>
                                                <td>Text</td>
                                                <td>Text</td>
                                                <td>Text</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Awaiting Appointments</h3></div>
                        <div id="awaiting_app" class="panel-body">
                            <div id="awaiting_list_view" class="List_view chat_list_view">
                                <ul class="chat" id="1"></ul>

                            </div>



                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">View History Details</h3></div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed">
                                    <thead>
                                        <tr class="success">
                                            <th>Column 1</th>
                                            <th>Column 2</th>
                                            <th>Column 2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Cell 1</td>
                                            <td>Cell 2</td>
                                            <td>Cell 2</td>
                                        </tr>
                                        <tr>
                                            <td>Cell 3</td>
                                            <td>Cell 4</td>
                                            <td>Cell 4</td>
                                        </tr>
                                        <tr>
                                            <td>Text</td>
                                            <td>Text</td>
                                            <td>Text</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <script src="assets/js/dropdown/bootstrap-select.js"></script>
            <?php include "pagelayout/footer.php" ?>
    </body>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].onclick = function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            }
        }
        function filterHosp()
        {
            var select_doc_specialty = $('#select_doc_specialty').val();
            console.log(select_doc_specialty);


            $.ajax({
                type: 'POST',
                url: 'gethosplist.php',
                data: {specialities: select_doc_specialty},
                success: function (data) {
                    document.getElementById("hospital_list").innerHTML = data;
                }
            });
        }

        $('#search_hosp').click(function () {
            filterHosp();
        });

        jQuery(document).ready(function () {

            getApp('get_waiting_app.php?' + 'doc_email=<?php echo $_SESSION['email']; ?>', "#awaiting_list_view ul");
            getApp('get_todays_app.php?' + 'doc_email=<?php echo $_SESSION['email']; ?>', "#todays_list_view ul");


            $("#awaiting_list_view").scroll(function () {
                var nextpage = $("#awaiting_app ul").attr("id");
                var currentpage = $("#awaiting_app ul").attr("currentpage");
                var totalpages = $("#awaiting_app ul").attr("totalpages");
                var infiniteList = $('#awaiting_list_view');
                // make sure u give the container id of the data to be loaded in.
                // if ((($("#awaiting_app").height()) - $("#awaiting_list_view").height() < 1) && (((currentpage) * view_height) - view_scroll <50) && (currentpage < totalpages) && !busy) {
                if ((infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) && currentpage < totalpages) {
                    // console.log("nextpage");
                    var pageUrl = 'get_waiting_app.php?page=' + nextpage + '&doc_email=<?php echo $_SESSION['email']; ?>';
                    getApp(pageUrl, "#awaiting_list_view ul");
                }
            });
            $("#todays_list_view").scroll(function () {
                var nextpage = $("#todays_app ul").attr("id");
                var currentpage = $("#todays_app ul").attr("currentpage");
                var totalpages = $("#todays_app ul").attr("totalpages");
                var infiniteList = $('#todays_list_view');
                // make sure u give the container id of the data to be loaded in.
                // if ((($("#awaiting_app").height()) - $("#awaiting_list_view").height() < 1) && (((currentpage) * view_height) - view_scroll <50) && (currentpage < totalpages) && !busy) {
                if ((infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) && currentpage < totalpages) {
                    // console.log("nextpage");
                    var pageUrl = 'get_todays_app.php?page=' + nextpage + '&doc_email=<?php echo $_SESSION['email']; ?>';
                    getApp(pageUrl, "#todays_list_view ul");
                }
            });
        });
        function getApp(pageurl, elementDoc)
        {   //console.log(this);
            $.ajax({
                type: 'GET',
                url: pageurl,
                success: function (data) {
                    var parsed_data = JSON.parse(data);
                    if (parsed_data.total_records != 0)
                    {
                        getAppData(parsed_data, elementDoc);
                    } else {
                        var liNode = document.createElement('li');
                        var liClass = document.createAttribute("class");
                        liClass.value = "left clearfix";
                        liNode.setAttributeNode(liClass);

                        var chatbodyNode = document.createElement('div');
                        var chatbodyClass = document.createAttribute("class");
                        chatbodyClass.value = "chat-body clearfix";
                        chatbodyNode.setAttributeNode(chatbodyClass);
                        var detailscontentNode = document.createElement('div');
                        var detailscontentClass = document.createAttribute("class");
                        detailscontentClass.value = "details_content";
                        detailscontentNode.setAttributeNode(detailscontentClass);
                        var nocontentNode = document.createTextNode("No Records ");
                        detailscontentNode.appendChild(nocontentNode);
                        chatbodyNode.appendChild(detailscontentNode);
                        liNode.appendChild(chatbodyNode);
                        $(elementDoc).append(liNode);
                    }
                }
            });

        }

        function getAppData(parsed_data, elementDoc)
        {
            if (parsed_data.places != null)
            {
                $(elementDoc).attr("id", parsed_data.nextpage);
                $(elementDoc).attr("currentpage", parsed_data.currentpage);
                $(elementDoc).attr("totalpages", parsed_data.total_pages);
                // console.log(parsed_data.places.appointments);
                $.each(parsed_data.places.appointments, function (i, val) {
                    var booking_id = this.booking_id;
                    var c_hos_name = this.c_hos_name;
                    var c_patient_name = this.c_patient_name;
                    var last_updated_date = this.last_updated_date;
                    var intial_char = this.intial_char;
                    var c_time = this.c_time;
                    var c_date = this.c_date;
                    var title = this.title;
                    var c_patient_phone = this.c_patient_phone;
                    var description = this.description;
                    var c_hos_address = this.c_hos_address;
                    var event_key = this.event_key;
                    var since_dt = this.since;
                    var patient_email = this.patient_email;
                    var event_status = this.status;


                    var liNode = document.createElement('li');
                    var liClass = document.createAttribute("class");
                    liClass.value = "left clearfix";
                    liNode.setAttributeNode(liClass);

                    var chatImgNode = document.createElement('span');
                    var chatImgClass = document.createAttribute("class");
                    chatImgClass.value = "chat-img pull-left";
                    chatImgNode.setAttributeNode(chatImgClass);

                    var avatarNode = document.createElement('div');
                    var avatarClass = document.createAttribute("class");
                    avatarClass.value = "avatar-circle";
                    avatarNode.setAttributeNode(avatarClass);

                    var initialsNode = document.createElement('span');
                    var initialsClass = document.createAttribute("class");
                    initialsClass.value = "initials";
                    initialsNode.setAttributeNode(initialsClass);
                    initialsNode.textContent = intial_char;
                    avatarNode.appendChild(initialsNode);
                    chatImgNode.appendChild(avatarNode);


                    var chatbodyNode = document.createElement('div');
                    var chatbodyClass = document.createAttribute("class");
                    chatbodyClass.value = "chat-body clearfix";
                    chatbodyNode.setAttributeNode(chatbodyClass);

                    var chatheaderNode = document.createElement('div');
                    var chatheaderClass = document.createAttribute("class");
                    chatheaderClass.value = "header";
                    chatheaderNode.setAttributeNode(chatheaderClass);

                    var primaryfontNode = document.createElement('strong');
                    var primaryfontClass = document.createAttribute("class");
                    primaryfontClass.value = "primary-font";
                    primaryfontNode.setAttributeNode(primaryfontClass);
                    primaryfontNode.textContent = "Patient Name :  " + c_patient_name;
                    chatheaderNode.appendChild(primaryfontNode);

                    var textmutedNode = document.createElement('small');
                    var textmutedClass = document.createAttribute("class");
                    textmutedClass.value = "pull-right text-muted";
                    textmutedNode.setAttributeNode(textmutedClass);

                    var timeNode = document.createElement('span');
                    var timeClass = document.createAttribute("class");
                    timeClass.value = "glyphicon glyphicon-time";
                    timeNode.setAttributeNode(timeClass);
                    textmutedNode.appendChild(timeNode);
                    //datetextNode = document.createTextNode(last_updated_date);
                    datetextNode = document.createTextNode(since_dt);
                    textmutedNode.appendChild(datetextNode);


                    chatheaderNode.appendChild(textmutedNode);
                    var brheadNode = document.createElement('br');
                    chatheaderNode.appendChild(brheadNode);
                    chatheaderNode.appendChild(primaryfontNode);


                    var detailscontentNode = document.createElement('div');
                    var detailscontentClass = document.createAttribute("class");
                    detailscontentClass.value = "details_content";
                    detailscontentNode.setAttributeNode(detailscontentClass);
                    var labelcontentNode = document.createElement('span');
                    var labelcontentClass = document.createAttribute("class");
                    labelcontentClass.value = "label_content";
                    labelcontentNode.setAttributeNode(labelcontentClass);
                    labelcontentNode.textContent = "Booking Id: ";
                    detailscontentNode.appendChild(labelcontentNode);
                    BookingTextNode = document.createTextNode(booking_id);
                    detailscontentNode.appendChild(BookingTextNode);
                    var br1Node = document.createElement('br');
                    detailscontentNode.appendChild(br1Node);
                    var label1contentNode = document.createElement('span');
                    var label1contentClass = document.createAttribute("class");
                    label1contentClass.value = "label_content";
                    label1contentNode.setAttributeNode(label1contentClass);
                    label1contentNode.textContent = "Hospital Name: ";
                    detailscontentNode.appendChild(label1contentNode);
                    BookingTextNode = document.createTextNode(c_hos_name);
                    detailscontentNode.appendChild(BookingTextNode);
                    var br2Node = document.createElement('br');
                    detailscontentNode.appendChild(br2Node);
                    var label2contentNode = document.createElement('span');
                    var label2contentClass = document.createAttribute("class");
                    label2contentClass.value = "label_content";
                    label2contentNode.setAttributeNode(label2contentClass);
                    label2contentNode.textContent = "Timing : ";
                    detailscontentNode.appendChild(label2contentNode);
                    BookingTextNode = document.createTextNode(c_time + " on " + c_date);
                    detailscontentNode.appendChild(BookingTextNode);
                    var brtNode = document.createElement('br');
                    detailscontentNode.appendChild(brtNode);
                    var titlecontentNode = document.createElement('span');
                    var titlecontentClass = document.createAttribute("class");
                    titlecontentClass.value = "label_content";
                    titlecontentNode.setAttributeNode(titlecontentClass);
                    titlecontentNode.textContent = "Title : ";
                    detailscontentNode.appendChild(titlecontentNode);
                    titleTextNode = document.createTextNode(title);
                    detailscontentNode.appendChild(titleTextNode);


                    var br4Node = document.createElement('br');
                    detailscontentNode.appendChild(br4Node);
                    var btngroupNode = document.createElement('div');
                    var toolbtnClass = document.createAttribute("class");
                    toolbtnClass.value = "btn-toolbar";
                    btngroupNode.setAttributeNode(toolbtnClass);

                    var viewbtn = document.createElement('button');
                    var viewbtnClass = document.createAttribute("class");

                    viewbtnClass.value = "btn btn-info btn-xs";
                    var viewbtnType = document.createAttribute("type");
                    viewbtnType.value = "button";
                    viewbtn.setAttributeNode(viewbtnType);
                    var viewbtnType = document.createAttribute("onclick");
                    viewbtnType.value = "showDetails(\"" + title + "\",\"" + c_patient_name + "\",\"" + c_hos_name + "\",\"" + c_patient_phone + "\",\"" + c_date + "\",\"" + c_time + "\",\"" + description + "\",\"" + c_hos_address + "\",\"" + booking_id + "\",\"" + event_key + "\",\"" + last_updated_date + "\",\"" + since_dt + "\",\"" + patient_email + "\",\""+event_status+"\")";
                    viewbtn.setAttributeNode(viewbtnType);
                    viewbtn.setAttributeNode(viewbtnClass);
                    viewbtn.textContent = "Details";
                    btngroupNode.appendChild(viewbtn);
                    var approvebtn = document.createElement('button');
                    var approvebtnClass = document.createAttribute("class");
                    approvebtnClass.value = "btn btn-success btn-xs";
                    var approvebtnType = document.createAttribute("type");
                    approvebtnType.value = "button";
                    approvebtn.setAttributeNode(approvebtnType);
                    var approvebtnType = document.createAttribute("onclick");
                    approvebtnType.value = "appoveApp(\"" + event_key  + "\",\"" + c_hos_name+ "\",\"" + c_date + "\",\"" + c_time +  "\",\"confirmed\",\"#008000\",\"" + elementDoc + "\")";
                    approvebtn.setAttributeNode(approvebtnType);
                    approvebtn.setAttributeNode(approvebtnClass);
                    approvebtn.textContent = "Approve";
                    btngroupNode.appendChild(approvebtn);
                    var rejectbtn = document.createElement('button');
                    var rejectbtnClass = document.createAttribute("class");
                    rejectbtnClass.value = "btn btn-danger btn-xs";
                    var rejectbtnType = document.createAttribute("type");
                    rejectbtnType.value = "button";
                    rejectbtn.setAttributeNode(rejectbtnType);
                    var rejectbtnType = document.createAttribute("onclick");
                    rejectbtnType.value = "appoveApp(\"" + event_key  + "\",\"" + c_hos_name+ "\",\"" + c_date + "\",\"" + c_time + "\",\"rejected\",\"#FF0000\",\"" + elementDoc + "\")";
                    rejectbtn.setAttributeNode(rejectbtnType);
                    rejectbtn.setAttributeNode(rejectbtnClass);
                    rejectbtn.textContent = "Reject";
                    btngroupNode.appendChild(rejectbtn);
//                    var sendinfobtn = document.createElement('button');
//                    var sendinfobtnClass = document.createAttribute("class");
//                    sendinfobtnClass.value = "btn btn-info btn-sm";
//                    var sendinfobtnType = document.createAttribute("type");
//                    sendinfobtnType.value = "button";
//                    sendinfobtn.setAttributeNode(sendinfobtnType);
//                     var sendinfobtnType = document.createAttribute("onclick");
//                    sendinfobtnType.value = "sendEmailInfo(\"" + title + "\",\"" + c_patient_name + "\",\"" + c_hos_name + "\",\"" + c_patient_phone + "\",\"" + c_date + "\",\"" + c_time + "\",\"" + description + "\",\"" + c_hos_address + "\",\"" + booking_id + "\",\"" + event_key + "\",\"" + last_updated_date + "\",\"" + since_dt + "\",\"" + patient_email + "\",\""+event_status+"\")";
//                    sendinfobtn.setAttributeNode(sendinfobtnType);
//                    sendinfobtn.setAttributeNode(sendinfobtnClass);
//                    sendinfobtn.textContent = "EmailInfo";
//                    btngroupNode.appendChild(sendinfobtn);
                    
                    
                    detailscontentNode.appendChild(btngroupNode);
                    var br3Node = document.createElement('br');
                    detailscontentNode.appendChild(br3Node);
                    chatbodyNode.appendChild(chatheaderNode);
                    chatbodyNode.appendChild(detailscontentNode);




                    liNode.appendChild(chatImgNode);
                    liNode.appendChild(chatbodyNode);
//                            return liNode;
                    $(elementDoc).append(liNode);

                });
            }

        }
        function cleanAppModal()
        {
            document.getElementById("app_title").innerHTML = "";
            document.getElementById("app_c_patient_name").innerHTML = "";
            document.getElementById("app_c_hos_name").innerHTML = "";
            document.getElementById("app_c_patient_phone").innerHTML = "";
            document.getElementById("app_c_date").innerHTML = "";
            document.getElementById("app_c_time").innerHTML = "";
            document.getElementById("app_description").innerHTML = "";
            document.getElementById("app_c_hos_address").innerHTML = "";
            document.getElementById("app_booking_id").innerHTML = "";
            document.getElementById("app_c_eventid").innerHTML = "";
            document.getElementById("app_c_last_updated_dt").innerHTML = "";
            document.getElementById("app_c_since_date").innerHTML = "";
            document.getElementById("app_c_patient_email").innerHTML = "";
            document.getElementById("app_c_event_status").innerHTML = "";
        }
         function sendEmailInfo(title, c_patient_name, c_hos_name, c_patient_phone, c_date, c_time, description, c_hos_address, booking_id, eventid, last_updated_dt, since_date, patient_email,event_status)
         {
            document.getElementById("app_title").innerHTML = title;
            document.getElementById("app_c_patient_name").innerHTML = c_patient_name;
            document.getElementById("app_c_hos_name").innerHTML = c_hos_name;
            document.getElementById("app_c_patient_phone").innerHTML = c_patient_phone;
            document.getElementById("app_c_date").innerHTML = c_date;
            document.getElementById("app_c_time").innerHTML = c_time;
            document.getElementById("app_description").innerHTML = description;
            document.getElementById("app_c_hos_address").innerHTML = c_hos_address;
            document.getElementById("app_booking_id").innerHTML = "Booking ID : " + booking_id;
            document.getElementById("app_c_eventid").innerHTML = eventid;
            document.getElementById("app_c_last_updated_dt").innerHTML = last_updated_dt;
            document.getElementById("app_c_since_date").innerHTML = since_date;
            document.getElementById("app_c_patient_email").innerHTML = patient_email;
            document.getElementById("app_c_event_status").innerHTML = event_status;
            
           // $('#viewAppointmentDetails').append('<link rel="stylesheet" href="" type="text/css" />');
          var modal = $('#viewAppointmentDetails').html();
          var fromEmail = '<?php echo $_SESSION['email']; ?>';
          var subject = "Booking Event :"+ eventid+ " on "+ c_date+ "  "+c_time+" @ "+c_hos_name+" - "+event_status ;
          var chatcss ='<?php  echo str_replace("\n","",file_get_contents("assets/css/chat.css"))?>';
          var bootcss = '<?php  echo str_replace("'","\'",(str_replace("\n","",file_get_contents("assets/css/01folder/bootstrap.min.css"))))?>';
          var message ='<html> <head>     <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">     <title>Email Notification</title>         <style media=\"all\" type=\"text/css\">   '+bootcss+chatcss+'    </style> </head> <body>'+modal.replace('\u00d7','')+'</body></html>';
                 
           $.ajax({
        type: 'POST',
                url: 'edit_calendar_event.php',
                data: {book_key: eventid,
                       },
                success: function (data) {
                var parsed_data = JSON.parse(data);
                var customer_email = parsed_data.customer_email;
                var status = parsed_data.status;
          sendEmail(customer_email,subject,message,fromEmail);
            }});
           
         }
         function sendEmail(customer_email,subject,message,fromEmail)
         {
             $.ajax({
        type: 'POST',
                url: 'sendemailnotification.php',
                data: {email: customer_email,
                        subject:subject,
                        message:message},
                success: function (data) {
                      $('#event_heading').text("Email sent Successfully");
                        $('#event_status').text("To EmailId : " +customer_email);
                        $('#result_status').modal('show');
                        setTimeout(function () {



                        $('#result_status').modal('hide');
                        }, 4000); // milliseconds
                    }
                });
         }
        function showDetails(title, c_patient_name, c_hos_name, c_patient_phone, c_date, c_time, description, c_hos_address, booking_id, eventid, last_updated_dt, since_date, patient_email,event_status)
        {
            cleanAppModal();
            document.getElementById("app_title").innerHTML = title;
            document.getElementById("app_c_patient_name").innerHTML = c_patient_name;
            document.getElementById("app_c_hos_name").innerHTML = c_hos_name;
            document.getElementById("app_c_patient_phone").innerHTML = c_patient_phone;
            document.getElementById("app_c_date").innerHTML = c_date;
            document.getElementById("app_c_time").innerHTML = c_time;
            document.getElementById("app_description").innerHTML = description;
            document.getElementById("app_c_hos_address").innerHTML = c_hos_address;
            document.getElementById("app_booking_id").innerHTML = "Booking ID : " + booking_id;
            document.getElementById("app_c_eventid").innerHTML = eventid;
            document.getElementById("app_c_last_updated_dt").innerHTML = last_updated_dt;
            document.getElementById("app_c_since_date").innerHTML = since_date;
            document.getElementById("app_c_patient_email").innerHTML = patient_email;
            document.getElementById("app_c_event_status").innerHTML = event_status;
            $('#viewAppointmentDetails').modal('show');

            // alert("title :" + title);
        }
        function updateEventStatus(event_key,c_hos_name,c_date,c_time, status, color, elementDoc)
        {
        $.ajax({
        type: 'POST',
                url: 'edit_calendar_event.php',
                data: {book_key: event_key,
                        status:status,
                        color:color},
                success: function (data) {
                var parsed_data = JSON.parse(data);
                        var event_id = parsed_data.key;
                        var status = parsed_data.status;
                        var operation = parsed_data.operation;
                         var customer_email = parsed_data.customer_email;
                         var fromEmail = '<?php echo $_SESSION['email']; ?>';
                          var subject =  "Booking Event :"+ event_id+ " on "+ c_date+ "  "+c_time+" @ "+c_hos_name+" - "+status ;
                         var message ='Your Appointment @'+c_hos_name+' on <b>'+c_date+' '+c_time+' </b> has been '+status+'<br> <br> Thank you <br>hms admin';
                         
                        $('#event_heading').text("Appointment - "+operation);
                        $('#event_status').text("Event Id : " +event_id+" is "+ status);
                        $('#result_status').modal('show');
                        setTimeout(function () {



                        $('#result_status').modal('hide');
                        }, 4000); // milliseconds
                        sendEmail(customer_email,subject,message,fromEmail);
                        if (elementDoc == "#todays_list_view ul")
                {
                        $(elementDoc).empty();
                getApp('get_todays_app.php?' + 'doc_email=<?php echo $_SESSION['email']; ?>', elementDoc);
                }
                else if (elementDoc == "#awaiting_list_view ul"){
                    $(elementDoc).empty();
                getApp('get_waiting_app.php?' + 'doc_email=<?php echo $_SESSION['email']; ?>', elementDoc);
                }
                }
                }).fail(function(jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
                });
        }

        function appoveApp(event_key,c_hos_name,c_date,c_time, status, color, elementDoc)
        {
        updateEventStatus(event_key,c_hos_name,c_date,c_time, status, color, elementDoc)
        }
    </script>

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="result_status" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 id="event_heading" class="modal-title">Event Id : Result</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <label id="event_status">no records found</label>
                    </div>


                </div>

            </div>
        </div>
    </div>

    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewAppointmentDetails" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title" id="app_booking_id">View Appointment</h4>
                </div>
                <div class="modal-body">
                    <div style="padding-bottom:15px">
                        <small id="app_c_since_date" class="pull-right text-muted"><span class="glyphicon glyphicon-time"></span>since_date</small>
                    </div>
                    <div  id="box">
                        <div class="box-top" style="color: #fff; 	background-color: #2980b9; 	text-shadow: 0px 0px 0px #ddd; 	padding: 5px; 	font-weight: 400;">
                            <label> Summary</label>
                        </div>
                        <div class="box-panel-content" style="padding: 5px; 	background-color: #fff; 	color: #041746; 	font-weight: 400; 	border-bottom: 1px;">
                            <label id="app_title" > </label>
                        </div>

                    </div>

                    <div  id="box">
                        <div class="box-panel" style="padding: 5px; 	background-color: rgba(208, 216, 223, 0.45); 	border-bottom: 1px; 	color: #333;">
                            <label>Description</label>
                        </div>
                        <div class="box-panel-content" style="padding: 5px; 	background-color: #fff; 	color: #041746; 	font-weight: 400; 	border-bottom: 1px;">
                            <label id="app_description" > </label>
                        </div>

                    </div>


                    <div>
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>

                            </thead>
                            <tbody>
<!--                                            <tr>
                                    <td class="col-md-3" style="text-align: center;font-weight: bold" >Summary</td>
                                   
                                    <td class="col-md-3"  id="app_title" style="text-align: justify">Cell 1</td>
                                  
                                 
                                </tr>-->
                                <tr>
                                    <td >Patient Name</td>
                                    <td id="app_c_patient_name">Cell 4</td>
                                </tr>
                                <tr>
                                    <td >Phone</td>
                                    <td id="app_c_patient_phone">Cell 4</td>
                                </tr>
                                <tr>
                                    <td >Email</td>
                                    <td id="app_c_patient_email">Cell 4</td>
                                </tr>

                                <tr>
                                    <td >Event ID</td>
                                    <td id="app_c_eventid">Cell 4</td>
                                </tr>
                                <tr>
                                    <td >Date</td>
                                    <td id="app_c_date">Cell 4</td>
                                </tr>
                                <tr>
                                    <td >Time</td>
                                    <td id="app_c_time">Cell 4</td>
                                </tr>
                                <tr>
                                    <td >Hospital Name</td>
                                    <td id="app_c_hos_name">Cell 4</td>
                                </tr>
                                <tr>
                                    <td >Hospital Address</td>
                                    <td id="app_c_hos_address">Cell 4</td>
                                </tr>
                                <tr>
                                    <td >Status</td>
                                    <td id="app_c_event_status">Cell 4</td>
                                </tr>
                                <tr>
                                    <td >Last UpdatedDt</td>
                                    <td id="app_c_last_updated_dt">Cell 4</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>

            </div>
        </div>
    </div>
    


</html>

