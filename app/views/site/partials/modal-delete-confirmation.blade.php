<!-- Dialog show event handler -->
<script type="text/javascript">
    $('#confirmDelete').modal('show').on('show.bs.modal', function (e) {
         $message = $(e.relatedTarget).attr('data-message');
         $(this).find('.modal-body p').html($message);
         $title = $(e.relatedTarget).attr('data-title');
         $(this).find('.modal-title').html($title);

         // Pass form reference to modal for submission on yes/ok
         var form = $(e.relatedTarget).closest('form');
         $(this).find('.modal-footer #confirm').data('form', form);*/
    });
    <!-- Form confirm (yes/ok) handler, submits form -->
    $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
        $(this).data('form').submit();
    });
</script>

<!-- Modal Dialog -->
<div class="modal" id="confirmDelete" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"">Delete Permanently</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure about this?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default border-0 border-radius-0" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger border-0 border-radius-0" id="confirm">Delete</button>
            </div>
        </div>
    </div>
</div>