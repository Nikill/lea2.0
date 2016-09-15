var TablesDatatables = function() {

    return {
        init: function() {
            /* Initialize Bootstrap Datatables Integration */
            App.datatables();

            /* Initialize Datatables */
            $('#article-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: [ 5 ] } ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
            });

            $('#role-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: [ 2 ] } ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
            });

            $('#factory-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: [ 4 ] } ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
            });

            $('#contact-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: [ 6 ] } ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
            });

            $('#subject-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: [ 3 ] } ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
            });

            $('#status-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: [ 2 ] } ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
            });

            /* Add placeholder attribute to the search input */
            $('.dataTables_filter input').attr('placeholder', 'Search');
        }
    };
}();