$('.set').click(function(){
    $tr = $(this).closest('tr');

    $data = $tr.children('td').map(function(){
        return $(this).text();
    }).get();

    console.log($data);
    if($data[2] == "None"){
        $('#editSet #currentAssignee').val(0);
        $('#editSet #empID').val(0);
        $('#editSet #none').hide();
    } else {
        $('#editSet #empID').val($data[3]);
        $('#editSet #currentAssignee').val($data[3]);
        $('#editSet #none').show();
    }
    $('#editSet #currentAssignee').html($data[2]);

    $('.modal #set').html($data[1]);
    $('#deleteBundle #delete').attr('href','lib/delete.php?set='+ $data[0]);

    $('#editSet #setID').val($data[0]);
    $('#editSet #set').val($data[1]);
    // $('#editSet #currentAssignee').html($data[2]);
    // $('#editSet #assignee').val($data[3]);
    // $('#editSet #empID').val($data[3]);
    
});

$('.item').click(function(){
    $tr = $(this).closest('tr');

    $data = $tr.children('td').map(function(){
        return $(this).text();
    }).get();

    // organize->change to class 

    

    $('#editItem #item').val($data[0]);
    $('#editItem #brand').val($data[2]);
    $('#editItem #unit').val($data[3]);
    $('#editItem #serial').val($data[4]);
    $('#editItem #purchaseDate').val($data[5]);
    $('#editItem #set').val($data[1]);
    $('#editItem #set').text($data[6]);

    $('#deleteItem #item').val($data[0]);
    $('#deleteItem #brand').val($data[1]);
    $('#deleteItem #unit').val($data[2]);
    $('#deleteItem #serial').val($data[3]);
    $('#deleteItem #purchaseDate').val($data[4]);
    $('#deleteItem #set').val($data[5]);
    
    $('#deleteItem #delete').attr('href','lib/delete.php?item='+ $data[0]);
}); 

$('.employee').click(function(){
    $tr = $(this).closest('tr');

    $data = $tr.children('td').map(function(){
        return $(this).text();
    }).get();
    
    console.log($data);

    if($data[3] == "None"){
        $('#editEmployee #none').hide();
        $('#editEmployee #currentBundle').html($data[3]);
        $('#editEmployee #currentBundle').val(0);
    } else {
        $('#editEmployee #none').show();
        $('#editEmployee #currentBundle').html($data[4]);
        $('#editEmployee #currentBundle').val($data[3]);
    }
    $('#editEmployee #employee').val($data[0]);
    $('#editEmployee #firstname').val($data[1]);
    $('#editEmployee #lastname').val($data[2]);

    

    // $('#editEmployee #set').val($data[1]);
    // $('#editEmployee #set').text($data[4]);

    $('#deleteEmployee #employee').val($data[0]);
    $('#deleteEmployee #firstname').val($data[1]);
    $('#deleteEmployee #lastname').val($data[2]);
    $('#deleteEmployee #set').val($data[4]);

    $('#deleteEmployee #delete').attr('href','lib/delete.php?employee='+ $data[0]);
});

$('.sidebar-item a').each(function(){
    if($(location).attr('pathname').includes($(this).attr('href'))){
        $(this).parent().addClass("active");
    } else if($(location).attr('pathname') == '/InventoryHR/'){
        $('.sidebar-item a[href="index.php"]').parent().addClass("active");
    }
});

function searchTable() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0]; // Change the index to the column you want to search
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }