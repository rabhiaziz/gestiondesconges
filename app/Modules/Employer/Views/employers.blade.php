@extends('layout')



@section('content')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://www.smart-team.tn/">Smart team</a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                @if($employer->role->id == 1)
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="{{route('index',['id'=>$employer->id])}}">Accueil</a></li>
                        <li><a href="{{route('employerList',['id'=>$employer->id])}}">Employés</a></li>
                    </ul>
                @endif
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Statut: {{$employer->role->role}}</a></li>
                </ul>
            </div><!--/.nav-collapse -->

        </div><!--/.container-fluid -->
    </nav>
    <div class="col-md-12">

        <div class="row">
            <div class="col-md-6">
                <h3>Liste des employés</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Nom </th>
                        <th scope="col">Role</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employers as $employer)
                        <tr>
                            <td><a href="#" onclick="showInfo({{$employer}})">{{$employer->name}}</a></td>
                            <td>{{$employer->role->role}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2">{{ $employers->links() }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="info">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Liste de congés pour <span id="emp-name"></span> </h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">la date de début </th>
                            <th scope="col">La date de fin</th>
                            <th scope="col">Commentaire</th>
                            <th scope="col">statut</th>
                        </tr>
                        </thead>
                        <tbody id="vacations-list">

                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@section('js')
    <script>
        function showInfo(data) {
            console.log(data.vacations);
            console.log(data.role.role);
            $('#emp-name').text(data.name);
            var html = '';
            if(data.vacations.length != 0){
                $.each(data.vacations,function(key,value){
                    html +='<tr>';
                    html +='<td>'+ value.start_date.replace('00:00:00', '') + '</td>';
                    html +='<td>'+ value.end_date.replace('00:00:00', '') + '</td>';
                    if(value.comment != null) {
                        html += '<td>' + value.comment + '</td>';
                    }else{
                        html += '<td>vide</td>';
                    }
                    if(value.status == 1){
                        html +='<td>Demande en attente</td>';
                    }else if(value.status == 2){
                        html +='<td>Approuvé</td>';
                    }else{
                        html +='<td>Refusé</td>';
                    }
                    html +='</tr>';
                });
            }else{

                    html +='<tr>';
                    html +='<td colspan="3"> Il n\'est pas de congé actuellement. </td>';
                    html +='</tr>';

            }
            $('#vacations-list').html(html);

            $('#info').modal('show');
        }
    </script>
@endsection
@endsection