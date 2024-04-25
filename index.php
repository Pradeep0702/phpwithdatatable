<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DataTable</title>
     <link href=" https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
     </head>
  <body>
  <div class="container mt-5">
      <table class="table table-bordered text-center" id="table">
        <label>Age</label>
        <select class="form-control" id="age">
           <option value="">Select Age Filter</option>
          <?php for($i=1;$i<=20;$i++){?>
          <option><?= $i ?></option>
          <?php } ?>
        </select>
        <label>Search</label>
        <input type="search" class="form-control mt-2" id="search">
        <button type="button" onclick="clearfilter()" class="btn btn-danger mt-2">Clear Filter</button>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Age</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody> 
      </tbody>
    </table>
</div>
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
   <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js "></script> 
  <script>
    const table = new DataTable('#table',{
            searching: false,
            paging: true,      
            processing: true,
            serverSide: true,
            ajax:{
              url:'action.php',
              data: function (d) {
                    return $.extend( {}, d, {
                      "age": $('#age').val(),
                      "search":$('#search').val(),
                    });
                  }
            },
           'columns': [
              { data: 'id' }, 
              { data: 'name' },
              { data: 'age' },  
              { data:'action'}           
         ]
          });     
        $('#age').on('change',function(){
          table.draw();
        }); 
        $('#search').on('keyup',function(){
             table.draw();
        });

        function clearfilter(){                       
            $('#age').val("");  
            $("#search").val("");          
            table.draw();
        } 
  </script>
  </body>
</html>