$('#sent').click(function () {UpFile(this);});

function UpFile(e)
{
    var file = $('#file');
    var img = $('#img');
    
    $.post(
        '/Test/Index/UploadFile',
        {
            File: $(file).contents()
        },
        function()
        {
            
        },
        file
    );

//    $.ajax({
//        type: "POST",
//        url: "/Test/Index/UploadFile",
//        enctype: 'multipart/form-data',
//        data: {
//            file: $(file).val()
//        },
//        success: function () {
//            alert("Data Uploaded: ");
//        }
//    });
    alert($(file).toString());
}