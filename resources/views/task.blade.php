<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Coalitiontechnologies</title>
    </head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="{{asset('plugins/jquery-ui/jquery-ui.css')}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .title{
            padding:20px 0px;
            text-align: center;
        }
        .content{
            max-width: 600px;
            max-height: 500px;
            overflow: auto;
            margin: auto;
            border-radius: 8px;
            border-style: dashed;
            padding: 10px;
        }
        .item{
            border-radius: 8px;
            border: 2px solid #dddddd;
            text-align: center;
            padding: 5px;
            cursor: pointer;
        }
        .item:hover{
            background-color: #dddddd;
            border: 2px solid #131212;
        }
        .action{
            max-width: 600px;
            margin: auto;
            padding: 10px 0;
        }
        .mb-10{
            margin-bottom: 10px;
        }
        .p-20{
            padding: 20px;
        }
    </style>
    <body>
        <h1 class="title">{{__('Coaliationtechnologies Task Management')}}</h1>
        <div class="action">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">Create Task</button>
        </div>
        <div class="content" id="task-content">
            @foreach($tasks as $task)
                <h4 class="item" data-id="{{ $task->id }}" data-toggle="modal" data-target="#modal-edit">{{ $task->name }}</h4>
            @endforeach
        </div>

        <!-- Start Create Modal -->
        <div class="modal fade" id="modal-create" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Create Task</h4>
                    </div>
                    <form action="{{url('add-task')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row p-20">
                                <!--begin::Label-->
                                <label class="form-label">
                                    <span>Task name</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control" name="name" placeholder="Your Task Name" required />
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Create Modal -->

        <!-- Start Create Modal -->
        <div class="modal fade" id="modal-edit" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Task</h4>
                    </div>
                    <form action="{{url('update-task')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" />
                        <div class="modal-body">
                            <div class="row p-20">
                                <!--begin::Label-->
                                <label class="form-label">
                                    <span>Task name</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control" name="name" placeholder="Your Task Name" required />
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger" id="btn-delete">Delete</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Create Modal -->

        <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="{{asset('plugins/jquery-ui/jquery-ui.js')}}"></script>
        <script>
            $(document).ready(function () {
                
                $('.item').on('click', function(){
                    var name = $(this).text();
                    var id = $(this).attr('data-id');
                    $('#modal-edit').find('input[name="name"]').val(name);
                    $('#modal-edit').find('input[name="id"]').val(id);
                    $('#btn-delete').attr('data-id', id);
                });

                $('#btn-delete').on('click', function(){
                    var result = confirm("Want to delete?");
                    if (result) {
                        var id = $(this).attr('data-id');
                        $.ajax({
                            method:'POST',
                            url: '{{ url('delete-task') }}',
                            data:{  
                              _token: $('input[name="_token"]').val(),
                              id: id,
                            },
                            success:function(res) {
                                location.href = "{{ url('/') }}";
                            }
                        });
                    }
                });

                var dropIndex;
                $("#task-content").sortable({
                    update: function(event, ui) { 
                        dropIndex = ui.item.index();
                        var priorityArray = [];
                        $('#task-content h4').each(function (index) {
                            var id = $(this).attr('data-id');
                            priorityArray.push(id);
                        });

                        $.ajax({
                            method:'POST',
                            url: '{{ url('update-priority') }}',
                            data:{  
                              _token: $('input[name="_token"]').val(),
                              priorityArray: priorityArray,
                            },
                            success:function(res) {
                                console.log(res)
                                alert('Successfully changed priority')
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>
