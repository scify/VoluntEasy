<div class="row">
    <div class="col-md-12">
        @if(sizeof($unit->allActions)==0)
        Δεν υπάροχυν δράσεις στη μονάδα.
        @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Όνομα</th>
                <th>Σχόλια</th>
                <th>Ημ. Έναρξης</th>
                <th>Ημ. Λήξης</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($unit->allActions as $action)
            <tr>
                <td>{{ $action->id }}</td>
                <td><a href="{{ url('actions/one/'.$action->id) }}">{{ $action->description }}</a>
                </td>
                <td>{{ $action->description }}</td>
                <td>{{ $action->start_date }}</td>
                <td>{{ $action->end_date }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        <hr/>
    </div>
</div>
