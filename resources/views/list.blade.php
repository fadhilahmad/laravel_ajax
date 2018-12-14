<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<meta name="csrf-token" content="{{ csrf_token() }}">-->
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Ajax List <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#exampleModal"><button class="btn btn-info btn-primary" >+</button></a></div>
                    <div class="panel-body">
                        <ul class="list-group">
                           @foreach ($item as $item)
                               <li class="list-group-item ourItem" data-toggle="modal" data-target="#exampleModal">{{$item['item']}}
                               <input type="hidden" id="itemId" value="{{$item->id}}" >
                               </li>                              
                           @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="title">Add Item
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="text" placeholder="type something" id="addp" class="form-control" required="required">
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id" >
                    <button type="button" class="btn btn-danger" id="delete" data-dismiss="modal" style="display: none">Delete</button>
                    <button type="button" class="btn btn-primary" id="update" style="display: none">Save changes</button>
                    <button type="button" class="btn btn-primary" id="add">Add</button>
                </div>
            </div>
        </div>
    </div>
    {{csrf_field()}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            
           $('.ourItem').each(function(){
                $(this).click(function(event){
                    var text = $(this).text();
                    var id = $(this).find('#itemId').val();
                    var text = $.trim(text);
                    $('#addp').val(text);
                    $('#title').text('Edit');
                    $('#delete').show('400');
                    $('#update').show('400');    
                    $('#add').hide('400');
                    $('#id').val(id); 
                });
            });
                
            $('#addNew').each(function(){
                $(this).click(function(event){
                    $('#addp').val("");
                    $('#title').text('Add Item');
                    $('#delete').hide('400');
                    $('#update').hide('400');    
                    $('#add').show('400');
                });
            });
            
            $('#add').click(function(event){
                var text = $('#addp').val();
                if(text== ""){
                    alert('Cannot be empty');
                    //$('#exampleModal').modal('show');
                }else{
                $.post('list', {'text': text, '_token': $('input[name=_token]').val() }, function(data){
                    $('#exampleModal').modal('hide');
                    location.reload();               
                });
                }
            });
            
            $('#delete').click(function(event){
                var id = $('#id').val();
                $.post('delete', {'id': id, '_token': $('input[name=_token]').val() }, function(data){
                    $('#exampleModal').modal('hide');
                    location.reload();
                });
            });
            
            $('#update').click(function(event){
                var text = $('#addp').val();
                var id = $('#id').val();
                $.post('update', {'id': id,'item':text, '_token': $('input[name=_token]').val() }, function(data){
                    //console.log(data);
                    $('#exampleModal').modal('hide');
                    location.reload();
                });
            });
            
        }); 
    </script>
</body>
</html>
