$(function() {
    function resetModalSize() {
        $('#modal-universe .modal-dialog').removeClass('modal-sm');
        $('#modal-universe .modal-dialog').removeClass('modal-lg');
        $('#modal-universe .modal-dialog').removeClass('modal-xl');
        $('#modal-universe .modal-dialog').removeClass('modal-full');
    }

    $(document).on('click', '.showModalButton', function() {
        resetModalSize();
        $('#modal-universe .modal-dialog').addClass($(this).attr('size'));
        $('#modal-universe').find('#modalContent').html('');
        $('#modal-universe').find('#modalContent').html("<div id='modalContent'><div style='text-align:center'><img src='../img/loader.gif'></div></div>");
        $('#modal-universe-label').html($(this).attr('title'));
        
        if ($('#modal-universe').data('bs.modal')?._isShown) {
            $('#modal-universe').find('#modalContent').load($(this).attr('value'));
        } else {
            $('#modal-universe').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'), function(response, status, xhr) {
                    if (status == "error") {
                        resetModalSize();
                        $('#modal-universe .modal-dialog').addClass('modal-xl');
                        var msg = 'An error was encountered while processing your request. ';
                        if (xhr.status == 403) msg = 'Anda tidak diizinkan untuk mengakses fitur ini. ';
                        $('#modalContent').html('<div class="alert bg-light pb-0"><div class="mb-6 alert alert-danger bg-light-danger border-danger border-dashed" style="margin-bottom:0px"><big><b>'+xhr.status + '</b> ' + xhr.statusText +'</big> <br><span class="text-muted">'+msg+'</span></div><div class="p-2">'+response+'</div></div>' );
                    }
                }
            );
        }
    });
});