$(function() {

    function set_device(id,value) {
        $.ajax({
            type: "POST",        
            url: "setdevice",
            data: {Device: { id: id, value: value}  }
        }).always( function (jqXHR, textStatus, errorThrown) {
            var error = false;            
            if (textStatus == "success"){
                var json_data = JSON.parse(jqXHR);
                if((json_data.result != undefined && !json_data.result ) || json_data.error != undefined){
                    error = true;
                }
            }else{ error = true; }   

            if(error){
                $(".device[data-id=" + id + "] .switch_device > button").removeClass("btn-primary").addClass("btn-danger");
            }  
      })
    }

    function update_control(){
        // handle start values
        $(".device").each(function (){ 
            device = $(this);
            device_value = device.find(".device_status").html();
            device_value_number = device_value.replace(/[^\d.]/g,'');
        
            if(device_value.indexOf("On") !==-1){
                device_value_number = 100;
            }else if(device_value.indexOf("Off") !==-1){
                device_value_number = 0;
            }
            
            device.find(".slider input").slider('setValue', device_value_number); 
            if(device_value_number > 0 && device_value_number <= 100){
                device.find("button").removeClass("btn-primary");
                device.find("button:nth-child(2)").addClass("btn-primary");      
            }else{
                device.find("button").removeClass("btn-primary");
                device.find("button:nth-child(1)").addClass("btn-primary"); 
            }
        });   
    }

    function getDeviceUpdates(){
        $.ajax({
            type: "GET",        
            url: "getdeviceupdate"
        }).always( function (jqXHR, textStatus, errorThrown) {
            var error = false;            
            if (textStatus == "success"){
                var json_data = JSON.parse(jqXHR);
                if(json_data.result == undefined || json_data.error != undefined){
                    error = true;
                }else{
                    // parse data
                    $.each( json_data.result,function() {
                        device = $(".device[data-id=" + this.deviceid+"]");
                        device.find(".device_status").html(this.value1 + " " + this.label1);
                        device.find(".device_lastseen").html(this.lastseen);                     
                        device.find(".device_value_2").html(this.value2 + " " + this.label2);             
                        device.find(".device_value_3").html(this.value3 + " " + this.label3);             
                        device.find(".device_value_4").html(this.value4 + " " + this.label4);             
                        // add value 2,3,4 lastseen  
                    })
                }
            }else{ error = true; }   

            if(error){
                $(".switch_device > button").removeClass("btn-primary").addClass("btn-danger");
            }else{
                update_control();    
            }  
            window.setTimeout(getDeviceUpdates, 5000);
      })        
    }

    // Toggle extra data and update icon
    $( ".device_name" ).click(function() {
        detail = $(this).parents(".device").children(".device_info");
        if ( detail.is(":visible") ){
            $(this).children("i").removeClass("icon-chevron-up").addClass("icon-chevron-down");    
        }else{
            $(this).children("i").removeClass("icon-chevron-down").addClass("icon-chevron-up");
        }    
        detail.slideToggle();

    });

    // Switch device
    $(".switch_device > button").click(function() {
        device_value = $(this).html();
        device = $(this).parents(".device");
        device.find("button").removeClass("btn-primary");
        $(this).addClass("btn-primary");
        
        if(device_value.indexOf("On") !==-1){
            device.find(".slider input").slider('setValue', 100);
        }else{
            device.find(".slider input").slider('setValue', 0);
        }

        device.find(".device_status").html(device_value);
        set_device(device.data("id"), device_value);
    });

    // dim device
    $('.slider').slider()
        .on('slideStop', function(ev){
            device_value = ev.value;
            device = $(this).parents(".device");

            if( (device_value > 0 && device_value <= 100)){
                device.find("button").removeClass("btn-primary");
                device.find("button:nth-child(2)").addClass("btn-primary");                
            }else{
                device.find("button").removeClass("btn-primary");
                device.find("button:nth-child(1)").addClass("btn-primary"); 
            }

            if(device_value == 0){
                device_value = "Off";
            }else if(device_value == 100){
                device_value = "On";
            }else{
                device_value= "Dim " + device_value;
            }
            
            device.find(".device_status").html(device_value);
            set_device(device.attr("id"), device_value);   
        });


    //start system
    update_control();
    getDeviceUpdates();

});



