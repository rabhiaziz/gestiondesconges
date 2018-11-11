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
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h3>Bonjour {{$employer->name}}</h3>
                </div>
            </div>
        </div>
    </div>
    @if($employer->role->id != 1)
    <div class="row">
        <div class="col-md-6">
            <h3>Liste des congés</h3>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">la date de début </th>
                    <th scope="col">La date de fin</th>
                    <th scope="col">Commentaire</th>
                    <th scope="col">statut</th>
                </tr>
                </thead>
                <tbody>
                @foreach($vacations as $vacation)
                <tr>
                    <td>{{$vacation->start_date->format('d/m/Y')}}</td>
                    <td>{{$vacation->end_date->format('d/m/Y')}}</td>
                    <td>{{$vacation->comment}}</td>
                    <td>
                        @if($vacation->status == 1)
                            Demande en attente
                        @elseif($vacation->status == 2)
                            Approuvé
                        @else
                            Refusé
                        @endif
                    </td>

                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">{{ $vacations->links() }}</td>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-md-6">
            <h3>Soumettre une demande de congés</h3>
            <form action="{{ route('addNewVacation', ['id'=>$employer->id]) }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group  @if ($errors->has('start_date')) has-error @endif">
                    <label for="start_date">La date de début:
                    </label>
                    <input name="start_date" type="text" class="form-control" value="" id="start">
                    @if ($errors->has('start_date'))
                    <span class="help-block">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('end_date')) has-error @endif">
                    <label for="end_date">La date de fin:</label>
                    <input name="end_date" type="text" class="form-control" value="" id="end">
                    @if ($errors->has('end_date'))
                        <span class="help-block">{{ $errors->first('end_date') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <textarea name="comment" class="form-control" id="" cols="4" rows="3" placeholder="Commentaire"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>

    </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <h3>Liste des congés</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Nom de l'employé </th>
                        <th scope="col">la date de début </th>
                        <th scope="col">La date de fin</th>
                        <th scope="col">Commentaire</th>
                        <th scope="col">statut</th>
                        @if($employer->role->id == 1)
                            <th scope="col">Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allVacations as $vacation)
                        <tr>
                            <td><a href="#" onclick="showInfo({{$vacation}})">{{$vacation->employer->name}}</a></td>
                            <td>{{$vacation->start_date->format('d/m/Y')}}</td>
                            <td>{{$vacation->end_date->format('d/m/Y')}}</td>
                            <td>{{$vacation->comment}}</td>
                            <td>
                                @if($vacation->status == 1)
                                    Demande en attente
                                @elseif($vacation->status == 2)
                                    Approuvé
                                @else
                                    Refusé
                                @endif
                            </td>

                            <td>
                                <form action="{{route('updateVacation',['id' =>$vacation->id])}}" method="post">
                                    {{csrf_field()}}
                                    <select name="approve" id="">
                                        <option value="2" @if($vacation->status == 2) selected @endif>Approuvé</option>
                                        <option value="3" @if($vacation->status == 3) selected @endif>Refusé</option>
                                    </select>
                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">{{ $vacations->links() }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    @endif
</div>

@section('js')
    <script type="text/javascript" src="{{asset('datepicker')}}/js/bootstrap-datepicker.js"></script>
    <script>
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#start').datepicker({
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('#end')[0].focus();
        }).data('datepicker');
        var checkout = $('#end').datepicker({
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');
    </script>

    <script>
        function showInfo(data) {
            console.log(data.employer);
        }
    </script>
@endsection
@endsection