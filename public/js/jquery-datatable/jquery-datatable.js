$(function () {
    $('.js-basic-example').DataTable();

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel',  'print'
        ],
         lengthMenu: [
      [ 10, 20, 30, 40, -1 ],
      [ '10', '20', '30', '40', 'Todo' ]
    ],
    
    });
});