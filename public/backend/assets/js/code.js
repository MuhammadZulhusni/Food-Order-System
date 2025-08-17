/**
 * Global function to handle delete, confirm, processing, and delivered actions
 * with a SweetAlert2 confirmation dialog.
 */
$(function(){

    /**
     * Handles the delete action with a confirmation dialog.
     * Prevents the default link behavior and shows a "Are you sure?" prompt.
     * If confirmed, it redirects the user to the provided link.
     */
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Delete This Data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                );
            }
        });
    });

    /**
     * Handles the 'Confirm Order' action with a confirmation dialog.
     * Redirects to the confirmation URL if the user clicks "Yes, Confirm it!".
     */
    $(document).on('click','#confirmOrder',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Confirm This Data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                    'Confirm!',
                    'Your file has been Confirm.',
                    'success'
                );
            }
        });
    });

    /**
     * Handles the 'Processing Order' action with a confirmation dialog.
     * Redirects to the processing URL if the user clicks "Yes, Processing it!".
     */
    $(document).on('click','#processingOrder',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Processing This Data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Processing it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                    'Processing!',
                    'Your file has been Processing.',
                    'success'
                );
            }
        });
    });

    /**
     * Handles the 'Delivered Order' action with a confirmation dialog.
     * Redirects to the delivered URL if the user clicks "Yes, deliverd it!".
     */
    $(document).on('click','#deliverdOrder',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
        
        Swal.fire({
            title: 'Are you sure?',
            text: "deliverd This Data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, deliverd it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                    'Delivered!',
                    'Your file has been deliverd.',
                    'success'
                );
            }
        });
    });
});