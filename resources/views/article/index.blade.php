<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <title>The Articles</title>
    <br><br><br>
</head>
<body>

    <div class = "container">  
      <div class="d-flex justify-content-between mb-2 p-2">
        @if($articles->count() >0)
          <button type="button" class="btn btn-danger" id="btn_delete_all" data-bs-toggle="modal" >Delete All</button>
        @endif
        <h1 >The Articles</h1>
        <a class="btn  btn-secondary d-flex align-items-center" href="{{ route('article.create') }}" role="button">Add New Article</a>
      </div>
      <table id="datatable" class="table" >
          <thead class="table-dark">
            <tr >
              <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Image</th>
              <th scope="col">Process</th>
            </tr>
          </thead>
          <tbody class = "table-info" >
            <?php $i = 0; ?>
            @foreach($articles as $article)
              <tr>            
                <?php $i++; ?>
                <td><input type="checkbox"  value="{{ $article->id }}" class="box1" ></td>
                <td>{{$i}}</td>
                <td>{{ $article->title }}</td>
                <td>
                    <img src="/images/articls/{{ $article->image }}" class="img-responsive" style="max-height: 100px; max-width: 100px;">
                </td>
                <td>
                  <div class="d-flex">
                    <form action="{{ route('article.edit',$article->id) }}" method="GET">
                      @csrf
                      <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                    <form action="{{ route('article.show',$article->id) }}" method="GET">
                      @csrf
                      <button type="submit" class="btn btn-dark">Show</button>
                    </form>
                    <form action="{{ route('article.destroy',$article->id) }}" method="POST">
                        {{ method_field('Delete') }}
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>

      <div class="modal fade" id="delete_all" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('delete_all') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    Are you sure delete ?
                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
            </div>
          </div>
        </div>
      </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js" integrity="sha512-ztxZscxb55lKL+xmWGZEbBHekIzy+1qYKHGZTWZYH1GUwxy0hiA18lW6ORIMj4DHRgvmP/qGcvqwEyFFV7OYVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script type="text/javascript">

      $(function() {
          $("#btn_delete_all").click(function() 
          {
              var selected = new Array();
              $("#datatable input[type=checkbox]:checked").each(function() 
              {
                
                if(this.id != 'example-select-all')
                {
                  selected.push(this.value);
                }
              });

              if (selected.length > 0) 
              {
                  
                  $('#delete_all').modal('show')
                  $('input[id="delete_all_id"]').val(selected);
              }
          });
      });

      
    </script>

    <script>
      function CheckAll(className, elem) 
      {
          var elements = document.getElementsByClassName(className);
          var l = elements.length;

          if (elem.checked) 
          {
              for (var i = 0; i < l; i++) 
              {
                  elements[i].checked = true;
              }
          } 
          else 
          {
              for (var i = 0; i < l; i++) 
              {
                  elements[i].checked = false;
              }
          }
      }
    </script>

</body>

</html>





