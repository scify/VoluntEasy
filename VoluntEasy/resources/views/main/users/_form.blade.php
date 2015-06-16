<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i
            class="fa fa-user m-r-xs"></i>Ατομικά Στοιχεία</a></li>
    <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-home m-r-xs"></i>Οργανωτικές Μονάδες</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active fade in" id="tab1">
        <div class="row m-b-lg">
            <div class="col-md-6">

                <div class="form-group">
                    {!! Form::formInput('name', 'Όνομα:', $errors, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::formInput('email', 'Email:', $errors, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::formInput('password', 'Κωδικός:', $errors, ['class' => 'form-control',
                    'type' =>'password']) !!}
                </div>
                <div class="form-group">
                    {!! Form::formInput('password_confirmation', 'Επιβεβαίωση κωδικού:', $errors,
                    ['class' => 'form-control', 'type' =>'password']) !!}
                </div>
                <div class="form-group">
                    {!! Form::formInput('addr', 'Διεύθυνση:', $errors, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::formInput('tel', 'Τηλέφωνο:', $errors, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
                </div>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tab2">
        <div class="row m-b-lg">
            <div class="col-md-4">
                @if(isset($user))
                @if (sizeof($user->units)==0)
                <h3>Ο χρήστης δεν ανήκει σε καμία οργανωτική μονάδα.</h3>
            </div>
            @else
            <ul class="list-unstyled">

                @foreach($user->units as $unit)
                <li><a href="#" class="unit" data-id="{{$unit->id}}">{{$unit->description}}</a></li>
                @endforeach

            </ul>
        </div>
        <div class="col-md-6">
            <div id="unitsTree"></div>
            @foreach($user->units as $unit)
            <ul id="unit-{{$unit->id}}" style="display:none;">
                <li>{{$unit->description}}
                    <ul>
                        @include('main.units.partials._branch', array('$unit->allChildren' => $unit))
                    </ul>
                </li>
            </ul>
            @endforeach
        </div>
        @endif
        @endif

    </div>
</div>
</div>


