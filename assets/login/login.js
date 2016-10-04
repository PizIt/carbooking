$(document).ready(function()
{
   $('#login').click(function(){
           $.login($('#username').val(),$('#password').val());
    });
   $('#ShowFormLogin').keyup(function(e){
       if(e.keyCode==13)
       {
            $.login($('#username').val(),$('#password').val());
       }
   })
$.login = function(username,password)
{
     $.ajax({
           async: false,
           type:'get',
           url: "login?username="+username+"&password="+password,
           success: function (data) {
                if(data!="")
                {
                    if(data=='success')
                    {   
                        swal({title:'Login Success',text:'',
                            type:'success',showConfirmButton: false}),
                                setTimeout(function(){location=""},2000);

                    }
                    else if(data=='fail')
                    {
                        swal({title:'Login Fail . . .Try again',text:'',
                            type:'error',timer: 2000, showConfirmButton: false});
                    }
                }
            }
       });
}
});