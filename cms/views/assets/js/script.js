var fileobj;

function upload_file(e) {
    e.preventDefault();
    for (i = 0; i < e.dataTransfer.files.length; i++) {
        fileobj = e.dataTransfer.files[i];
        ajax_file_upload(fileobj);
    }
}



function file_explorer() {
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function() {
        for (var i = 0; i < this.files.length; i++) {
            fileobj = document.getElementById('selectfile').files[i];
            ajax_file_upload(fileobj);
        }
    };
}

function goBack() {
    window.history.back();    
}

function invalidFunction(e, message) {
    e.preventDefault();
    document.getElementById('hataMesaji').innerText = message;
    document.getElementById('hataMesaji').className = "badge badge-danger";
}


function imgSlider() {
    var imgEl = document.querySelector('.upload-slider')

    imgEl.setAttribute('src', URL.createObjectURL(event.target.files[0]))
};


$(document).ready(function() {
    $('#category').on('change', function() {
        var cat_id = this.value;
        $.ajax({
            url: "../operations/controllers/urunlerController.php",
            type: "POST",
            data: {
                cat_id: cat_id
            },
            cache: false,
            success: function(result){
                console.log(result);
                $("#sub-category").html(result);
            }
        });
    });
    $('#edit-category').on('change', function() {
        var edit_cat_id = this.value;
        $.ajax({
            url: "../operations/controllers/urunlerController.php",
            type: "POST",
            data: {
                edit_cat_id: edit_cat_id
            },
            cache: false,
            success: function(result){
                console.log(result);
                $("#edit-sub-category").html(result);
            }
        });
    });
    $('#services-category').on('change', function() {
        var cat_id = this.value;
        $.ajax({
            url: "../operations/controllers/hizmetController.php",
            type: "POST",
            data: {
                cat_id: cat_id
            },
            cache: false,
            success: function(result){
                // console.log(result);
                $("#services-sub-category").html(result);
            }
        });
    });
    $('#edit-services-category').on('change', function() {
        var edit_cat_id = this.value;
        $.ajax({
            url: "../operations/controllers/hizmetController.php",
            type: "POST",
            data: {
                edit_cat_id: edit_cat_id
            },
            cache: false,
            success: function(result){
                // console.log(result);
                $("#edit-services-sub-category").html(result);
            }
        });
    });
    $(".fiyat").change(function() {
        $(this).val(parseFloat($(this).val()).toFixed(2));
    });
    
});








